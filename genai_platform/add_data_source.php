<?php

$apiToken = 'YOUR_DIGITALOCEAN_API_TOKEN';  // Your DigitalOcean API token
$knowledgeBaseUuid = '12345678-1234-1234-1234-123456789012';  // Your Knowledge Base UUID
$apiUrl = "https://api.digitalocean.com/v2/gen-ai/knowledge_bases/{$knowledgeBaseUuid}/data_sources";  // API URL

// Data source payload
$payload = [
    "knowledge_base_uuid" => "12345678-1234-1234-1234-123456789012", //KB ID
    "spaces_data_source" => [
        "bucket_name" => "example-bucket",  // Replace with your Space bucket name
        "item_path" => "path/to/your/file.html",  // Path to your file within the Space
        "region" => "nyc3"  // Your region, e.g., 'nyc3' for New York
    ],
];

// Initialize cURL session
$ch = curl_init($apiUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiToken",  // Authorization header with the token
    "Content-Type: application/json"  // Content type as JSON
]);

curl_setopt($ch, CURLOPT_POST, true);  // Set method to POST
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));  // Attach payload to the request
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return response as string

// Execute cURL request and capture the response
$response = curl_exec($ch);

// Error handling
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);  // If an error occurs, output the error message
} else {
    echo 'Response: ' . $response;  // Output the response from the API
}

// Close the cURL session
curl_close($ch);
?>