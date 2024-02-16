<?php
require_once 'OAuth2Client.php';
require_once 'Dynamics365Client.php';
require_once 'Field.php';

// Logique pour créer un contact
try {
    $oauthClient = new OAuth2Client($tenantId, $clientId, $clientSecret, $resource);
    $accessToken = $oauthClient->getAccessToken()->getToken();

    $dynamicsClient = new Dynamics365Client($accessToken);
    $fields = [
        new Field('firstname', 'John'),
        new Field('lastname', 'Doe'),

    ];
    $contact = $dynamicsClient->createContact($fields);
    echo "Contact créé avec succès. ID: " . $contact['contactid'];
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
