<?php

$accessKey = 'YOUR_AGENT_ACCESS_KEY';  // Replace with your Agent access key
$agentEndpoint = 'https://YOUR_AGENT_ID.ondigitalocean.app';  // Replace with your agent endpoint
$apiUrl = "{$agentEndpoint}/api/v1/chat/completions";  // Full API URL

// Payload for the chat completion request
$payload = [
    "messages" => [
        [
            "role" => "user",
            "content" => "What is the capital of France?"
        ]
    ],
    "stream" => false,
    "include_functions_info" => false,
    "include_retrieval_info" => false,
    "include_guardrails_info" => false
];

// Initialize cURL session
$ch = curl_init($apiUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $accessKey",  // Bearer token
    "Content-Type: application/json"     // Content type
]);

curl_setopt($ch, CURLOPT_POST, true);  // Set method to POST
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));  // Attach JSON payload
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return response as string
curl_setopt($ch, CURLOPT_HEADER, true);  // Include response headers in output

// Execute cURL request and capture the response
$response = curl_exec($ch);

// Get response metadata
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);  // Get size of headers
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // Get HTTP status code
$header = substr($response, 0, $headerSize);  // Extract headers
$body = substr($response, $headerSize);  // Extract body

// Error handling
if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch) . "\n";
} elseif ($httpCode >= 400) {
    echo "HTTP Error $httpCode:\n";
    echo "Response Body: $body\n";
} else {
    echo "Success (HTTP $httpCode):\n";
    echo "Response: $body\n";
}

// Close the cURL session
curl_close($ch);
?>
