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

    $result = $client->updateIndex([
        'applicationId' => '<string>', // REQUIRED
        'capacityConfiguration' => [
            'units' => '<integer>',
        ],
        'description' => '<string>',
        'displayName' => '<string>',
        'documentAttributeConfigurations' => [
            [
                'name' => '<string>',
                'search' => 'ENABLED|DISABLED',
                'type' => 'STRING|STRING_LIST|NUMBER|DATE',
            ],
            // ...
        ],
        'indexId' => '<string>', // REQUIRED
    ]);

    // Handle successful result
    echo "Index updated successfully: " . print_r($result, true);
} catch (QBusinessException $e) {
    // Output error message if it fails
    echo "Error updating index: " . $e->getMessage();
} catch (Exception $e) {
    // Handle other exceptions
    echo "Error: " . $e->getMessage();
}
