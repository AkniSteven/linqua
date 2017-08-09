<?php

namespace  IlinquaTest\Model\Abstractions;

/**
 * Class AdminPages
 * @package IlinquaTest\Model\Abstractions
 */
abstract class AdminPages
{
    /**
     * AdminPages constructor.
     */
    public function __construct()
    {
        add_action('admin_menu', [ &$this, 'addAdminPage' ]);
        add_action('admin_init', [ &$this, 'registerSettings' ]);
    }
    /**
     * Method to register settings
     *
     * @return mixed
     */
    abstract public function registerSettings();
    /**
     * Method to display settings page.
     *
     * @return mixed
     */
    abstract public function displaySettingsPage();
    /**
     * Method to add Admin page
     *
     * @return mixed
     */
    abstract public function addAdminPage();
}