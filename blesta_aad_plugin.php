<?php

use Blesta\Core\Util\Common\Traits\Container;

/**
 * Microsoft Entra ID plugin handler
 * @link https://speed-cloud.fr SPEED CLOUD
 */
class BlestaAADPlugin extends Plugin
{
    // Load traits
    use Container;

    /**
     * @var Monolog\Logger An instance of the logger
     */
    protected $logger;

    public function __construct()
    {
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');

        // Initialize logger
        $logger = $this->getFromContainer('logger');
        $this->logger = $logger;
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
        return ['head' => '<!-- This is just a test. -->'];
    }
    
}
