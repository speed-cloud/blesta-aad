<?php
/**
 * Microsoft Entra ID plugin handler
 *
 * @copyright Copyright (c) 2025, SPEED CLOUD
 * @license GPL
 * @link https://speed-cloud.fr SPEED CLOUD
 */
class Callback extends AppController
{
    /**
    * Handle callback requests
    */
    public function index()
    {
        $code = $this->get['code'] ?? null;
        if (!$code) {
          return;
        }
      
        $tenant_id = $this->Companies->getSetting($this->company_id, 'MsEntraId.tenant_id')->value ?? '';
        $client_id = $this->Companies->getSetting($this->company_id, 'MsEntraId.client_id')->value ?? '';
        $client_secret = $this->Companies->getSetting($this->company_id, 'MsEntraId.client_secret')->value ?? '';

        $ch = curl_init('https://login.microsoftonline.com/' . $tenant_id . '/oauth2/v2.0/token');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'authorization_code',
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $code,
            'redirect_uri' => $this->base_url . 'plugin/ms_entra_id/callback'
        ]));

        $token = json_decode(curl_exec($ch), true)['access_token'];
        curl_close($ch);
        
        $ch = curl_init('https://graph.microsoft.com/oidc/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADERS, ['Authorization' => 'Bearer ' . $token]);

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        var_dump($response);
    }

    /**
     * Make a request to Microsoft Entra ID.
     * 
     * @param string $method Request method used 
     * @param string $url URL called
     */
    private function makeRequest($method, $url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
                          
        ]);
    }
}
