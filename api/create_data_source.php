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

// echo '<pre>';
// foreach ($tempCredentials as $key => $value) {
//     echo $key . ': ' . $value . "\n";
// }
// echo '</pre>';

try {
    $result = $client->createDataSource([
        'applicationId' => 'd0021987-01c5-4ff2-9be4-ff9c1e482603',
        'configuration' => [
            'type' => 'WEBCRAWLERV2',
            'syncMode' => 'FULL_CRAWL',
            'connectionConfiguration' => [
                'repositoryEndpointMetadata' => [
                    // 'siteMapUrls' => ['https://support.crystaldash.com/sitemap.xml'],
                    'seedUrlConnections' => [
                        ['seedUrl' => 'https://support.crystaldash.com/article/show/140878-how-to-add-email-signature'] //dynamic
                    ],
                    'authentication' => 'NoAuthentication', //dynamic, use website credentials
                ],
            ],
            'repositoryConfigurations' => [
                'webPage' => [
                    'fieldMappings' => [
                        [
                            'indexFieldName' => 'title',
                            'indexFieldType' => 'STRING',
                            'dataSourceFieldName' => 'page_title',
                            'dateFieldFormat' => "yyyy-MM-dd'T'HH:mm:ss'Z'",
                        ],
                    ],
                ],
                'attachment' => [
                    'fieldMappings' => [
                        [
                            'indexFieldName' => 'attachment_title',
                            'indexFieldType' => 'STRING',
                            'dataSourceFieldName' => 'attachment_name',
                            'dateFieldFormat' => "yyyy-MM-dd'T'HH:mm:ss'Z'",
                        ],
                    ],
                ],
            ],
            'additionalProperties' => [
                'rateLimit' => '300',
                'maxFileSize' => '50',
                'crawlDepth' => '4',
                'maxLinksPerUrl' => '999',
                'crawlSubDomain' => false,
                'crawlAllDomain' => false,
                'crawlAttachments' => true,
                'honorRobots' => false,
                // 'inclusionURLCrawlPatterns' => [
                // '^https:\/\/support\.crystaldash\.com$',
                // '^https:\/\/support\.crystaldash\.com\/.*'
                // ],
                // 'inclusionURLIndexPatterns' => [
                //     '^https:\/\/support\.crystaldash\.com$',
                //     '^https:\/\/support\.crystaldash\.com\/.*'
                // ],
            ],

        ],

        'mediaExtractionConfiguration' => [
            'imageExtractionConfiguration' => [
                'imageExtractionStatus' => 'ENABLED',
            ],
        ],
        'description' => 'My data source from support.crystaldash.com from API', //dynamic
        'displayName' => 'Support_CrystalDash', //dynamic allowed [a-z,A-Z,_-] nospace
        'indexId' => 'b9d8bc3a-9f49-41e1-a418-1513248628d0',
        'roleArn' => 'arn:aws:iam::354870356684:role/QBusinessRole',
        'syncSchedule' => '',
    ]);


    echo "✅ Data source created successfully:\n";
    print_r($result);

} catch (AwsException $e) {
    echo $e->getAwsErrorMessage();
}
