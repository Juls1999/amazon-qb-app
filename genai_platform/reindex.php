<?php

$apiToken = 'YOUR_DIGITALOCEAN_API_TOKEN';  // Your DigitalOcean API token
$knowledgeBaseUuid = '12345678-1234-1234-1234-123456789012';  // Your Knowledge Base UUID
$apiUrl = "https://api.digitalocean.com/v2/gen-ai/indexing_jobs";  // API URL

// Data source payload
$payload = [
    "knowledge_base_uuid" => $knowledgeBaseUuid,  // KB ID
    "data_source_uuids" => [
        "example string"  // Replace with your actual data source UUID(s)
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
