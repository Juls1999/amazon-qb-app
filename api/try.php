<?php
require '../vendor/autoload.php';
session_start(); // Start the session to track conversation + credentials

use Aws\Sts\StsClient;
use Aws\QBusiness\QBusinessClient;
use Aws\Exception\AwsException;
use Aws\SSOOIDC\SSOOIDCClient;
use Aws\SSO\SSOClient;
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
function cacheToJsonFile($filePath, $data)
{
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $jsonData);
}

function getFromJsonCacheFile($filePath)
{
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        return json_decode($jsonData, true);
    }
    return null;
}

try {
    $cacheFilePath = __DIR__ . '/../cache/temp_creds.json';
    $cachedSsoOidcResult = getFromJsonCacheFile($cacheFilePath);
    $currentTime = time();

    $shouldRegister = false;

    if (
        !$cachedSsoOidcResult ||
        !isset($cachedSsoOidcResult['clientId'], $cachedSsoOidcResult['clientSecret'], $cachedSsoOidcResult['clientSecretExpiresAt']) ||
        $cachedSsoOidcResult['clientSecretExpiresAt'] <= $currentTime
    ) {
        $shouldRegister = true;
    }

    if ($shouldRegister) {
        // Register new client
        $ssoOidcClient = new SsoOidcClient([
            'version' => 'latest',
            'region' => 'us-west-2',
            'credentials' => [
                'key' => $tempCredentials['AccessKeyId'],
                'secret' => $tempCredentials['SecretAccessKey'],
                'token' => $tempCredentials['SessionToken'],
            ],
        ]);

        $ssoOidcResult = $ssoOidcClient->registerClient([
            'clientName' => 'PublicChat',
            'clientType' => 'public',
        ]);

        // Cache the new client info
        cacheToJsonFile($cacheFilePath, [
            'clientId' => $ssoOidcResult['clientId'],
            'clientSecret' => $ssoOidcResult['clientSecret'],
            'clientSecretExpiresAt' => $ssoOidcResult['clientSecretExpiresAt'],
        ]);

        $clientId = $ssoOidcResult['clientId'];
        $clientSecret = $ssoOidcResult['clientSecret'];
        $clientSecretExpiresAt = $ssoOidcResult['clientSecretExpiresAt'];

    } else {
        // Use cached values
        $clientId = $cachedSsoOidcResult['clientId'];
        $clientSecret = $cachedSsoOidcResult['clientSecret'];
        $clientSecretExpiresAt = $cachedSsoOidcResult['clientSecretExpiresAt'];
    }

    // Use SSO OIDC client to start device authorization
    $ssoOidcClient = new SsoOidcClient([
        'version' => 'latest',
        'region' => 'us-west-2',
        'credentials' => [
            'key' => $tempCredentials['AccessKeyId'],
            'secret' => $tempCredentials['SecretAccessKey'],
            'token' => $tempCredentials['SessionToken'],
        ],
    ]);

    // $result = $ssoOidcClient->createTokenWithIAM([
    //     'clientId' => 'arn:aws:sso::354870356684:application/ssoins-79071025c91fd908/apl-002135f5a67d1024',
    //     'code' => 'yJraWQiOiJrZXktMTU2Njk2ODA4OCIsImFsZyI6IkhTMzg0In0EXAMPLEAUTHCODE',
    //     'grantType' => 'authorization_code',
    //     'redirectUri' => 'https://mywebapp.example/redirect',
    //     'scope' => [
    //         'openid',
    //         'aws',
    //         'sts:identity_context',
    //     ],
    // ]);

    $startResponse = $ssoOidcClient->startDeviceAuthorization([
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
        'startUrl' => 'https://my-sso-portal.awsapps.com/start',
    ]);

    // Use Puppeteer to automate login
    $escapedUrl = escapeshellarg($startResponse['verificationUriComplete']);
    $puppeteerOutput = shell_exec("node ../api/automated_login.js $escapedUrl 2>&1");
    echo "<pre>$puppeteerOutput</pre>"; // See output directly in the browser

    if (strpos($puppeteerOutput, 'Login automation failed') !== false) {
        echo "Puppeteer login failed!";
    } else {
        // Direct token creation attempt without the while loop
        try {
            $tokenResponse = $ssoOidcClient->createToken([
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
                'deviceCode' => $startResponse['deviceCode'],
                'grantType' => 'urn:ietf:params:oauth:grant-type:device_code',
            ]);

            // Success!
            $accessToken = $tokenResponse['accessToken'];
            $refreshToken = $tokenResponse['refreshToken'];
            echo "ACCESSTOKEN: $accessToken <br> REFRESHTOKEN: $refreshToken";
        } catch (AwsException $e) {
            echo "Error while creating token: " . $e->getMessage();
        }
    }

    $ssoClient = new SsoClient([
        'version' => 'latest',
        'region' => 'us-west-2',
        'credentials' => [
            'key' => $tempCredentials['AccessKeyId'],
            'secret' => $tempCredentials['SecretAccessKey'],
            'token' => $tempCredentials['SessionToken'],
        ],
    ]);

    // Create User temp creds
    // $ssoResult = $ssoClient->getRoleCredentials([
    //     'accessToken' => '<string>', // REQUIRED from createToken
    //     'accountId' => '354870356684', // REQUIRED
    //     'roleName' => 'QBusinessRole', // REQUIRED 
    // ]);

    // echo $ssoResult;

    // Create QBusiness client using session credentials
    // $qbClient = new QBusinessClient([
    //     'version' => 'latest',
    //     'region' => 'us-west-2',
    //     'credentials' => [
    //         'key' => $ssoResult['AccessKeyId'],
    //         'secret' => $ssoResult['SecretAccessKey'],
    //         'token' => $ssoResult['SessionToken'],
    //     ],
    // ]);

    // $qbResult = $qbClient->chatSync([
    //     'applicationId' => 'd0021987-01c5-4ff2-9be4-ff9c1e482603',
    //     'chatMode' => 'CREATOR_MODE', // or 'RETRIEVAL_MODE'
    //     'userMessage' => 'What is the name of the 5th planet from the Sun in our Solar System?',
    // ]);

} catch (AwsException $e) {
    echo "Error: " . $e->getMessage();
}
