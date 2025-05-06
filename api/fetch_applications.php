<?php
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


    $timestamp = time();
    $randomString = bin2hex(random_bytes(4)); // 8 characters long random string
    $sessionName = 'qbusiness-session-' . $timestamp . '-' . $randomString;

    $result = $stsClient->assumeRole([
        'RoleArn' => 'arn:aws:iam::354870356684:role/QBusinessRole',
        'RoleSessionName' => $sessionName,
    ]);

    $tempCredentials = [
        'AccessKeyId' => $result['Credentials']['AccessKeyId'],
        'SecretAccessKey' => $result['Credentials']['SecretAccessKey'],
        'SessionToken' => $result['Credentials']['SessionToken'],
        'Expiration' => $result['Credentials']['Expiration'], // ISO format
    ];

    saveCredentialsToCache($cacheFile, $tempCredentials);
}



try {
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

    // Fetch list of applications with a maximum of 1 result
    $result = $client->listApplications([
        'maxResults' => 10, // Fetch up to 10 results instead of 1
    ]);

    $applications = [];

    if (isset($result['applications']) && count($result['applications']) > 0) {
        foreach ($result['applications'] as $application) {
            $applications[] = [
                'id' => $application['applicationId'],
                'name' => $application['displayName'],
                'status' => $application['status'],
                'created_at' => $application['createdAt']->format('Y-m-d H:i:s'),
                'updated_at' => $application['updatedAt']->format('Y-m-d H:i:s')
            ];
        }
    }

    echo json_encode(['success' => true, 'data' => $applications]);

} catch (AwsException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>