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

        $params = $event->getParams();
        $replace_admin_login_page = $this->Companies->getSetting(Configure::get('Blesta.company_id'), 'MsEntraId.replace_admin_login_page')->value ?? 'off';
        
        if ($params['controller'] !== 'admin_login'
            || $replace_admin_login_page !== 'on'
            || ($this->Session->read('blesta_id') > 0
                && $this->Session->read('blesta_staff_id') > 0)) {
            return;
        }

        return header('Location: ' . WEBDIR . 'plugin/ms_entra_id/login');
    }
}
