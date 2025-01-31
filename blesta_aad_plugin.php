<?php
class BlestaAADPlugin extends Plugin
{

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
