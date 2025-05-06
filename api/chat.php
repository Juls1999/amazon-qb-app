<?php
session_start(); // Start the session to track the conversation ID

require '../vendor/autoload.php';

use Aws\Sts\StsClient;
use Aws\QBusiness\QBusinessClient;
use Aws\Exception\AwsException;
use Dotenv\Dotenv;

// Load your IAM user credentials from .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Path to cache file
$cacheFile = __DIR__ . '/../cache/temp_credentials.json';

// Function to load cached credentials
function loadCachedCredentials($path)
{
    if (!file_exists($path))
        return null;

    $data = json_decode(file_get_contents($path), true);
    if (!$data || !isset($data['Expiration']))
        return null;

    $expiration = strtotime($data['Expiration']);
    if ($expiration <= time() + 60)
        return null; // Less than 1 min left = expired

    return $data;
}

// Function to save credentials to cache
function saveCredentialsToCache($path, $credentials)
{
    file_put_contents($path, json_encode($credentials, JSON_PRETTY_PRINT));
}

// Try to load cached credentials
$tempCredentials = loadCachedCredentials($cacheFile);

// If not cached or expired, assume role again
if (!$tempCredentials) {
    $stsClient = new StsClient([
        'region' => 'us-west-2',
        'version' => 'latest',
        'credentials' => [
            'key' => $_ENV['ACCESS_KEY'],
            'secret' => $_ENV['SECRET_ACCESS_KEY'],
        ],
    ]);

    $result = $stsClient->assumeRole([
        'RoleArn' => 'arn:aws:iam::354870356684:role/QBusinessRole',
        'RoleSessionName' => 'qbusiness-session',
    ]);

    $tempCredentials = [
        'AccessKeyId' => $result['Credentials']['AccessKeyId'],
        'SecretAccessKey' => $result['Credentials']['SecretAccessKey'],
        'SessionToken' => $result['Credentials']['SessionToken'],
        'Expiration' => $result['Credentials']['Expiration'], // ISO format
    ];

    saveCredentialsToCache($cacheFile, $tempCredentials);
}

// echo '<pre>';
// foreach ($tempCredentials as $key => $value) {
//     echo $key . ': ' . $value . "\n";
// }
// echo '</pre>';


// Function to get the valid conversation ID if available
function getValidConversationId()
{
    // Check if a valid conversationId exists in session
    if (!empty($_SESSION['conversationId']) && strlen($_SESSION['conversationId']) >= 36) {
        return $_SESSION['conversationId']; // Return if it's a valid string
    }

    return null; // Return null if not valid
}
// Create QBusiness client using temp credentials
$client = new QBusinessClient([
    'version' => 'latest',
    'region' => 'us-west-2',
    'credentials' => [
        'key' => $tempCredentials['AccessKeyId'],
        'secret' => $tempCredentials['SecretAccessKey'],
        'token' => $tempCredentials['SessionToken'],
    ],
]);

try {
    $result = $client->chatSync([
        'applicationId' => 'd0021987-01c5-4ff2-9be4-ff9c1e482603', // REQUIRED
        'chatMode' => 'CREATOR_MODE',
        // 'conversationId' => '<string>',
        // 'parentMessageId' => '<string>',
        'userMessage' => 'What is the planet 5th from the Sun?',
    ]);

    echo $result;

} catch (AwsException $e) {
    echo $e->getMessage();
}