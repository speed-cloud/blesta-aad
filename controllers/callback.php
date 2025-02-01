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
        $this->uses(['Record']);
        
        $tenant_id = $this->Companies->getSetting($this->company_id, 'MsEntraId.tenant_id')->value ?? '';
        $client_id = $this->Companies->getSetting($this->company_id, 'MsEntraId.client_id')->value ?? '';
        $client_secret = $this->Companies->getSetting($this->company_id, 'MsEntraId.client_secret')->value ?? '';

        $ch = curl_init('https://login.microsoftonline.com/' . $tenant_id . '/oauth2/v2.0/token');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'authorization_code',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'code' => $this->get['code'],
                'redirect_uri' => $this->base_url . 'plugin/ms_entra_id/callback'
            ]),
        ]);
        
        $token = json_decode(curl_exec($ch))->access_token;
        curl_close($ch);

        if (!$token) {
            return $this->redirect($this->base_uri . 'plugin/ms_entra_id/login');
        }
        
        $ch = curl_init('https://graph.microsoft.com/oidc/userinfo');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token]
        ]);

        $email = json_decode(curl_exec($ch))->email;
        curl_close($ch);

        $staff = $this->Record->select()
            ->from('staff')
            ->where('email', '=', $email)
            ->fetch();

        var_dump($staff);
    }
}
