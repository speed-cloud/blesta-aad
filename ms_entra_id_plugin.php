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
        $this->logger->log($event);
    }
    
}
