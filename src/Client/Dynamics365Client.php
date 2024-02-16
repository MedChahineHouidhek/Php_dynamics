<?php
require_once './src/Auth/OAuth2Client.php';

class Dynamics365Client
{
    private $accessToken;

    public function __construct($accessToken) {
        $this->accessToken = $accessToken;
    }

    public function createContact($fields)
    {
        $url = 'https://anfv1.crm.dynamics.com/api/data/v9.1/contacts'; 
        $data = ['attributes' => []];

        foreach ($fields as $field) {
            $data['attributes'][$field->attributeName] = $field->value;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->accessToken,
            'OData-MaxVersion: 4.0',
            'OData-Version: 4.0'
        ]);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        } else {
            return json_decode($response, true);
        }
    }
}
