<?php
require '../vendor/autoload.php';

use Aws\QBusiness\QBusinessClient;
use Aws\QBusiness\Exception\QBusinessException;
//use AWS\SecretsManager\SecretsManagerClient;

try {

    // $secretsClient = new SecretsManagerClient([
    //     'version' => 'latest',
    //     'region' => 'us-west-2', // Update with your desired region
    // ]);

    // $secret = $secretsClient->getSecretValue([
    //     'SecretId' => 'secret_id'
    // ]);

    // $credentials = json_decode($secret['SecretString'], true);


    // Create a new Bedrock Agent client
    $client = new QBusinessClient([
        'version' => 'latest',
        'region' => 'us-west-2', // Update with your desired region
        'credentials' => [
            'key' => 'AWS_ACCESS_KEY_ID', //$credentials['AWS_ACCESS_KEY_ID'],
            'secret' => 'AWS_SECRET_ACCESS_KEY'//$credentials['AWS_SECRET_ACCESS_KEY'],
        ],
    ]);

    $result = $client->putFeedback([
        'applicationId' => '<string>', // REQUIRED
        'conversationId' => '<string>', // REQUIRED
        'messageCopiedAt' => '<integer || string || DateTime>',
        'messageId' => '<string>', // REQUIRED
        'messageUsefulness' => [
            'comment' => '<string>',
            'reason' => 'NOT_FACTUALLY_CORRECT|HARMFUL_OR_UNSAFE|INCORRECT_OR_MISSING_SOURCES|NOT_HELPFUL|FACTUALLY_CORRECT|COMPLETE|RELEVANT_SOURCES|HELPFUL|NOT_BASED_ON_DOCUMENTS|NOT_COMPLETE|NOT_CONCISE|OTHER',
            'submittedAt' => '<integer || string || DateTime>', // REQUIRED
            'usefulness' => 'USEFUL|NOT_USEFUL', // REQUIRED
        ],
        'userId' => '<string>',
    ]);


    // Handle successful result
    echo "Feedback created successfully: " . print_r($result, true);
} catch (QBusinessException $e) {
    // Output error message if it fails
    echo "Error creating feedback: " . $e->getMessage();
} catch (Exception $e) {
    // Handle other exceptions
    echo "Error: " . $e->getMessage();
}
