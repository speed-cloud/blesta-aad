<?php

use Blesta\Core\Util\Common\Traits\Container;

/**
 * Microsoft Entra ID plugin handler
 *
 * @copyright Copyright (c) 2025, SPEED CLOUD
 * @license GPL
 * @link https://speed-cloud.fr SPEED CLOUD
 */
class MsEntraIdPlugin extends Plugin
{
    public function __construct()
    {
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');

        Language::loadLang('ms_entra_id', null, dirname(__FILE__) . DS . 'language' . DS);
    }

    /**
     * Listen to events.
     * @return array
     */
    public function getEvents()
    {
        return [
            [
                'event' => 'Appcontroller.structure',
                'callback' => ['this', 'on_admin_login'],
            ]
        ];
    }

    /**
     * Handles when an admin tries to access the admin page.
     *
     * @param array $event
     * @return array
     */
    public function on_admin_login($event)
    {
        if (!isset($this->Companies)) {
            Loader::loadComponents($this, ['Companies']);
        }
        
        // Get params
        $params = $event->getParams();
        
        if ($params['controller'] !== 'admin_login'
            || $this->Companies->getSetting(Configure::get('Blesta.company_id'), 'MsEntraId.replace_admin_login_page')->value !== 'on') {
            return;
        }

        return header('Location: ' . WEBDIR . 'plugins/ms_entra_id/login');
    }
}
