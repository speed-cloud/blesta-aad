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
        $this->redirect('https://login.microsoftonline.com/' . Configure::get('MsEntraId.tenant_id') . '/oauth2/v2.0/authorize?' . http_build_query([
            'client_id' => Configure::get('MsEntraId.client_id'),
            'response_type' => 'code',                                                                                                                                        
            'scope' => 'openid email profile',                                                                                                                  
            'redirect_uri' => $this->base_uri . 'plugin/ms_entra_id/callback',                                                                                                       
        ]));
    }
}
