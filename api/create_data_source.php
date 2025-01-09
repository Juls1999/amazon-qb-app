<?php
require '../vendor/autoload.php';

use Dotenv\Dotenv;
use Aws\QBusiness\QBusinessClient;
use Aws\Exception\AwsException;


// Correctly load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); // Load .env file from the root directory
$dotenv->load();

try {

    // this function is for learning purposes, this should be static [will be deleted after the creation of QB App]
    function generateApplicationId()
    {
        // The first character should be alphanumeric (a-z, A-Z, 0-9)
        $firstChar = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 1);

        // The remaining 35 characters can be alphanumeric or hyphen
        $remainingChars = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-'), 0, 35);

        // Concatenate the first character with the remaining 35 characters
        $applicationId = $firstChar . $remainingChars;

        return $applicationId;
    }


    // this function is for learning purposes, this should be static [will be deleted after the creation of QB App]
    function generateIndexId()
    {
        // The first character should be alphanumeric (a-z, A-Z, 0-9)
        $firstChar = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 1);

        // The remaining 35 characters can be alphanumeric or hyphen
        $remainingChars = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-'), 0, 35);

        // Concatenate the first character with the remaining 35 characters
        $IndexId = $firstChar . $remainingChars;

        return $IndexId;
    }



    // Create a new Bedrock Agent client
    $client = new QBusinessClient([
        'version' => 'latest',
        'region' => 'us-west-2', // Update with your desired region
        'credentials' => [
            'key' => $_ENV['ACCESS_KEY'], //$credentials['AWS_ACCESS_KEY_ID'],
            'secret' => $_ENV['SECRET_ACCESS_KEY']//$credentials['AWS_SECRET_ACCESS_KEY'],
        ],
    ]);

    $result = $client->createDataSource([
        'applicationId' => generateApplicationId(), // REQUIRED [the agent's ID]
        'configuration' => [
            'type' => 'WEBCRAWLERV2', // Changed to WEBCRAWLERV2
            'syncMode' => 'FULL_CRAWL',
            //'secretArn' => 'arn:aws:secretsmanager:us-west-2:123456789012:secret:my-secret', // Updated ARN
            'connectionConfiguration' => [
                'repositoryEndpointMetadata' => [
                    'seedUrlConnections' => [
                        [
                            'seedUrl' => 'https://example.com' //the domain of the website that will serve as the data source
                        ]
                    ],
                    'authentication' => 'NoAuthentication', // Specify BASIC_AUTH
                ]
            ],
            'additionalProperties' => [
                'rateLimit' => 300,
                'maxFileSize' => 200,
                'crawlDepth' => 2,
                'maxLinksPerUrl' => 100,
                'crawlSubDomain' => true,
                'crawlAllDomain' => true,
                'crawlAttachments' => true,
                'maxFileSizeInMegaBytes' => 50,
                'honorRobots' => false // Set to false to ignore robots.txt
            ],
        ],
        'mediaExtractionConfiguration' => [
            'imageExtractionConfiguration' => [
                'imageExtractionStatus' => 'ENABLED', // REQUIRED
            ],
        ],
        'description' => 'Data Source for my Q business application',
        'displayName' => 'MyDataSource', // REQUIRED
        'indexId' => generateIndexId(), // REQUIRED
        'syncSchedule' => '',
    ]);

    // Handle successful result
    echo "Data source created successfully: " . print_r($result, true);

} catch (AwsException $e) {
    // Handle other exceptions
    echo "Error: " . $e->getMessage();
}
