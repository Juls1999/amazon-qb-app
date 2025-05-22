<?php

// BETTER TO USE CONSOLE (1 Time Setup)

$apiToken = 'YOUR_DIGITALOCEAN_API_TOKEN';
$apiUrl = 'https://api.digitalocean.com/v2/gen-ai/knowledge_bases';

$payload = [
    // "database_id" => "12345678-1234-1234-1234-123456789012",
    "datasources" => [
        [
            "web_crawler_data_source" => [
                "base_url" => "https://support.crystaldash.com",
                "crawling_option" => "BROAD", // Use "RECURSIVE" or "SINGLE_PAGE"
                "embed_media" => true
            ]
        ]
    ],
    "embedding_model_uuid" => "12345678-1234-1234-1234-123456789012",
    "name" => "My Knowledge Base",
    "project_id" => "12345678-1234-1234-1234-123456789012",
    "region" => "tor1",
    "tags" => ["example string"],
    "vpc_uuid" => "12345678-1234-1234-1234-123456789012"
];

$ch = curl_init($apiUrl);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $apiToken",
    "Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo 'Response: ' . $response;
}

curl_close($ch);
