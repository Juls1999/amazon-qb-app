<?php

// Load environment variables from the .env file
require '../vendor/autoload.php'; // Make sure you've installed the vlucas/phpdotenv library

use Dotenv\Dotenv;
use Aws\QBusiness\QBusinessClient;
use Aws\Exception\AwsException;

// Correctly load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); // Load .env file from the root directory
$dotenv->load();

try {

    $client = new QBusinessClient([
        'version' => 'latest',
        'region' => 'us-west-2', // Update with your desired region
        'credentials' => [
            'key' => $_ENV['ACCESS_KEY'],  // Get the access key from the .env file
            'secret' => $_ENV['SECRET_ACCESS_KEY'],  // Get the secret key from the .env file
        ],
    ]);

    $result = $client->getRetriever([
        'applicationId' => 'd0021987-01c5-4ff2-9be4-ff9c1e482603', // REQUIRED
        'retrieverId' => '518522d1-e497-4cf5-815b-64b7ab19ce0a', // REQUIRED
    ]);
    // Output the  result
    echo " Result: " . print_r($result, true);

} catch (AwsException $e) {
    // Output error message if it fails
    echo "Error syncing chat: " . $e->getMessage();
}




?>