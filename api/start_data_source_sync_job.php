<?php

require "../vendor/autoload.php";

use Dotenv\Dotenv;
use Aws\QBusiness\QBusinessClient;
use Aws\Exception\AwsException;


// Correctly load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); // Load .env file from the root directory
$dotenv->load();
try {

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

    function generateDataSourceId()
    {
        // The first character should be alphanumeric (a-z, A-Z, 0-9)
        $firstChar = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 1);

        // The remaining 35 characters can be alphanumeric or hyphen
        $remainingChars = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-'), 0, 35);

        // Concatenate the first character with the remaining 35 characters
        $dataSourceId = $firstChar . $remainingChars;

        return $dataSourceId;
    }

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

    $client = new QBusinessClient([
        'version' => 'latest',
        'region' => 'us-west-2', // Update with your desired region
        'credentials' => [
            'key' => $_ENV['ACCESS_KEY'],  // Get the access key from the .env file
            'secret' => $_ENV['SECRET_ACCESS_KEY'],  // Get the secret key from the .env file
        ],
    ]);

    $result = $client->startDataSourceSyncJob([
        'applicationId' => generateApplicationId(), // REQUIRED
        'dataSourceId' => generateDataSourceId(), // REQUIRED
        'indexId' => generateIndexId(), // REQUIRED
    ]);

    // Handle successful result
    echo "Data source synced successfully: " . print_r($result, true);
} catch (AwsException $e) {
    //input error msg if fails
    echo "Error syncing the data source:" . $e->getMessage();
}