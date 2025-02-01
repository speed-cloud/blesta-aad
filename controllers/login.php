<?php
/**
 * Microsoft Entra ID plugin handler
 *
 * @copyright Copyright (c) 2025, SPEED CLOUD
 * @license GPL
 * @link https://speed-cloud.fr SPEED CLOUD
 */
class Login extends AppController
{
    /**
    * Handle login requests
    */
    public function index()
    {
        // Get settings
        $tenant_id = $this->Companies->getSetting($this->company_id, 'MsEntraId.tenant_id')->value ?? '';
        $client_id = $this->Companies->getSetting($this->company_id, 'MsEntraId.client_id')->value ?? '';
        
        $this->redirect('https://login.microsoftonline.com/' . $tenant_id . '/oauth2/v2.0/authorize?' . http_build_query([
            'client_id' => $client_id,
            'response_type' => 'code',                                                                                                                                        
            'scope' => 'openid email profile',                                                                                                                  
            'redirect_uri' => $this->base_uri . 'plugin/ms_entra_id/callback',                                                                                                       
        ]));
    }
}
