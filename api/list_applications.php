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

    // Create a new client using credentials from .env file
    $client = new QBusinessClient([
        'version' => 'latest',
        'region' => 'us-west-2', // Update with your desired region
        'credentials' => [
            'key' => $_ENV['ACCESS_KEY'],  // Get the access key from the .env file
            'secret' => $_ENV['SECRET_ACCESS_KEY'],  // Get the secret key from the .env file
        ],
    ]);

    $result = $client->listApplications([
        'maxResults' => 1,
    ]);



    // Output the filtered result
    echo "Applications: " . print_r($filteredResult, true);

} catch (AwsException $e) {
    // Output error message if it fails
    echo "Error Listing Applications: " . $e->getMessage();
}
