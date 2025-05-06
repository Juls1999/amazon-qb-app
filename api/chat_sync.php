<?php
require '../vendor/autoload.php';
session_start(); // Start the session to track conversation + credentials



use Aws\Sts\StsClient;
use Aws\QBusiness\QBusinessClient;
use Aws\Exception\AwsException;
use Dotenv\Dotenv;

// Load your IAM user credentials from .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Helper: Load cached credentials from session
function getSessionCredentials()
{

    if (
        isset($_SESSION['sts_credentials']) &&
        isset($_SESSION['sts_credentials']['Expiration']) &&
        strtotime($_SESSION['sts_credentials']['Expiration']) > time() + 60 // valid for at least 1 more minute
    ) {
        // Print session data for debugging
        echo '<pre>';
        print_r($_SESSION['sts_credentials']); // This will print all session data
        echo '</pre>';
        return $_SESSION['sts_credentials'];
    }
    return null;
}

// Helper: Get fresh credentials via STS assumeRole
function getFreshStsCredentials()
{
    $stsClient = new StsClient([
        'region' => 'us-west-2',
        'version' => 'latest',
        'credentials' => [
            'key' => $_ENV['ACCESS_KEY'],
            'secret' => $_ENV['SECRET_ACCESS_KEY'],
        ],
    ]);

    $timestamp = time();
    $randomString = bin2hex(random_bytes(4));
    $sessionName = 'qbusiness-session-' . $timestamp . '-' . $randomString;

    $result = $stsClient->assumeRole([
        'RoleArn' => 'arn:aws:iam::354870356684:role/QBusinessRole', // <-- Make sure this is the user role
        'RoleSessionName' => $sessionName,
        'DurationSeconds' => 10800,
    ]);

    $tempCredentials = [
        'AccessKeyId' => $result['Credentials']['AccessKeyId'],
        'SecretAccessKey' => $result['Credentials']['SecretAccessKey'],
        'SessionToken' => $result['Credentials']['SessionToken'],
        'Expiration' => $result['Credentials']['Expiration'], // ISO8601 string
    ];

    // Save to session
    $_SESSION['sts_credentials'] = $tempCredentials;
    // Print session data for debugging
    echo '<pre>';
    print_r($_SESSION['sts_credentials']); // This will print all session data
    echo '</pre>';
    return $tempCredentials;
}

// Load valid credentials from session or get fresh
$tempCredentials = getSessionCredentials() ?? getFreshStsCredentials();

// Helper: Get valid conversation ID
function getValidConversationId()
{
    return (!empty($_SESSION['conversationId']) && strlen($_SESSION['conversationId']) >= 36)
        ? $_SESSION['conversationId']
        : null;
}

try {
    // Create QBusiness client using session credentials
    $client = new QBusinessClient([
        'version' => 'latest',
        'region' => 'us-west-2',
        'credentials' => [
            'key' => $tempCredentials['AccessKeyId'],
            'secret' => $tempCredentials['SecretAccessKey'],
            'token' => $tempCredentials['SessionToken'],
        ],
    ]);

    // Prepare chatSync request
    $params = [
        'applicationId' => 'd0021987-01c5-4ff2-9be4-ff9c1e482603',
        'chatMode' => 'CREATOR_MODE', // or 'RETRIEVAL_MODE'
        'userMessage' => 'What is the name of the 5th planet from the Sun in our Solar System?',
    ];

    if ($conversationId = getValidConversationId()) {
        $params['conversationId'] = $conversationId;
    }

    // Call chatSync API
    $result = $client->chatSync($params);

    // Save conversation ID back to session
    if (!empty($result['conversationId'])) {
        $_SESSION['conversationId'] = $result['conversationId'];
    }

    // Display filtered result
    $filteredResult = [
        'systemMessage' => $result['systemMessage'] ?? null,
        'systemMessageId' => $result['systemMessageId'] ?? null,
        'userMessageId' => $result['userMessageId'] ?? null,
        'conversationId' => $result['conversationId'] ?? null,
    ];

    echo "Filtered Result: " . print_r($filteredResult, true);

} catch (AwsException $e) {
    echo "Error syncing chat: " . $e->getMessage();
}
