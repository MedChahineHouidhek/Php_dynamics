<?php
require_once './vendor/autoload.php';
require_once __DIR__ . '../config/config.php';

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class OAuth2Client
{
    private $provider;

    public function __construct()
    {
        // Initialiser le fournisseur OAuth2 avec les configurations d'Azure AD
        $this->provider = new GenericProvider([
            'clientId'                => AZURE_AD_CLIENT_ID, // Utiliser la constante définie dans config.php
            'clientSecret'            => AZURE_AD_CLIENT_SECRET, // Utiliser la constante définie dans config.php
            'redirectUri'             => '',
            'urlAuthorize'            => "https://login.microsoftonline.com/" . AZURE_AD_TENANT_ID . "/oauth2/authorize",
            'urlAccessToken'          => "https://login.microsoftonline.com/" . AZURE_AD_TENANT_ID . "/oauth2/token",
            'urlResourceOwnerDetails' => '',
            'scopes'                  => DYNAMICS_365_RESOURCE_URL . '/.default'
        ]);
    }

    public function getAccessToken()
    {
        try {
            // Tenter d'obtenir un jeton d'accès en utilisant le type de grant 'client_credentials'
            $accessToken = $this->provider->getAccessToken('client_credentials');
            return $accessToken;
        } catch (IdentityProviderException $e) {
            // Gérer l'erreur d'obtention du jeton d'accès
            throw new \Exception("Erreur lors de l'obtention du jeton d'accès : " . $e->getMessage());
        }
    }
}
