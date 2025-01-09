<?php
session_start(); // Start the session to track the conversation ID

// Handle session timeout, if inactive for 30mins
if (!isset($_SESSION['LAST_ACTIVITY']) || (time() - $_SESSION['LAST_ACTIVITY']) > 1800) {
    session_unset(); // Clear session variables
    session_destroy(); // Destroy the session
    session_start(); // Start a new session
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update the last activity timestamp

// Load environment variables from the .env file
require '../vendor/autoload.php'; // Make sure you've installed the vlucas/phpdotenv library

use Dotenv\Dotenv;
use Aws\QBusiness\QBusinessClient;
use Aws\Exception\AwsException;

// Correctly load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); // Load .env file from the root directory
$dotenv->load();

try {
    function generateConversationId()
    {
        if (!isset($_SESSION['conversationId'])) {
            // The first character should be alphanumeric (a-z, A-Z, 0-9)
            $firstChar = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 1);

            // The remaining 35 characters can be alphanumeric or hyphen
            $remainingChars = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-'), 0, 35);

            // Concatenate the first character with the remaining 35 characters
            $_SESSION['conversationId'] = $firstChar . $remainingChars;

            return $_SESSION['conversationId'];
        }
        return $_SESSION['conversationId'];
    }

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

    // Create a new client using credentials from .env file
    $client = new QBusinessClient([
        'version' => 'latest',
        'region' => 'us-west-2', // Update with your desired region
        'credentials' => [
            'key' => $_ENV['ACCESS_KEY'],  // Get the access key from the .env file
            'secret' => $_ENV['SECRET_ACCESS_KEY'],  // Get the secret key from the .env file
        ],
    ]);

    $result = $client->chatSync([
        'applicationId' => generateApplicationId(), // REQUIRED [for now, I created a dynamic ID for learning purposes]
        'chatMode' => 'RETRIEVAL_MODE', // Chat mode for custom knowledge
        'conversationId' => generateConversationId(), // Session Management
        'userId' => '<string>', // The ID of the subscribed user (Lite or Pro)
        'userMessage' => '<string>', // End user message in a conversation
    ]);

    // Extract only the required fields
    $filteredResult = [
        'systemMessage' => $result['systemMessage'] ?? null,
        'systemMessageId' => $result['systemMessageId'] ?? null,
        'userMessageId' => $result['userMessageId'] ?? null,
        'conversationId' => $result['conversationId'] ?? null,
    ];

    // Output the filtered result
    echo "Filtered Result: " . print_r($filteredResult, true);

} catch (AwsException $e) {
    // Output error message if it fails
    echo "Error syncing chat: " . $e->getMessage();
}
