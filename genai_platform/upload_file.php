<?php

require '../vendor/autoload.php'; // Autoload Composer dependencies
use Aws\S3\S3Client;

// Initialize the S3Client for DigitalOcean Spaces
$client = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',
    'endpoint' => 'https://nyc3.digitaloceanspaces.com', // DigitalOcean Spaces endpoint
    'use_path_style_endpoint' => false,
    'credentials' => [
        'key'    => getenv('SPACES_KEY'), // Replace with your DigitalOcean Spaces API key
        'secret' => getenv('SPACES_SECRET'), // Replace with your DigitalOcean Spaces secret key
    ],
]);

// Path to the HTML file you want to upload
$filePath = '../file/sm.html'; // Replace with the actual file path
$objectName = 'sample.html'; // The name under which the file will be stored in the Space

// Set up parameters for the upload
$params = [
    'Bucket' => 'your-space-name', // Replace with your Space name
    'Key'    => $objectName,       // The file name in your Space
    'Body'   => fopen($filePath, 'r'), // Open the file and upload its contents
    'ACL'    => 'public-read',     // Make the file publicly readable
    'ContentType' => 'text/html',  // Set the content type to HTML
];

// Upload the file to the Space
try {
    $result = $client->putObject($params);
    echo "File uploaded successfully! URL: https://your-space-name.nyc3.digitaloceanspaces.com/{$objectName}\n";
} catch (Aws\Exception\AwsException $e) {
    // Output any errors encountered
    echo "Error uploading file: " . $e->getMessage() . "\n";
}

