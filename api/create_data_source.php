<?php
require '../vendor/autoload.php';

use Dotenv\Dotenv;
use Aws\QBusiness\QBusinessClient;
use Aws\Exception\AwsException;


// Correctly load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); // Load .env file from the root directory
$dotenv->load();

try {

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
        'applicationId' => 'd0021987-01c5-4ff2-9be4-ff9c1e482603', // REQUIRED [the agent's ID]
        'configuration' => [
            'type' => 'WEBCRAWLERV2', // Changed to WEBCRAWLERV2
            'syncMode' => 'FULL_CRAWL',
            //'secretArn' => 'arn:aws:secretsmanager:us-west-2:123456789012:secret:my-secret', // Updated ARN
            'connectionConfiguration' => [
                'repositoryEndpointMetadata' => [
                    'seedUrlConnections' => [
                        [
                            'seedUrl' => 'https://www.crystaldash.com/' //the domain of the website that will serve as the data source
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
        'indexId' => 'b9d8bc3a-9f49-41e1-a418-1513248628d0', // REQUIRED
        'syncSchedule' => '',
    ]);

    // Handle successful result
    echo "Data source created successfully: " . print_r($result, true);

} catch (AwsException $e) {
    // Handle other exceptions
    echo "Error: " . $e->getMessage();
}
