<?php
/*
 * @package RzaPlugin
 */
namespace inc\pages;
use \inc\Base\BaseController;
use \inc\Api\SettingsApi;
use \inc\Api\Callbacks\AdminCallbacks;

class Dashboard extends BaseController
{
    public $settings;
    public $callbacks;
    public $pages = array();

    /**
     * admin constructor.
     */
    public function register()
    {
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->setPages();

        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
    }

    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title'=> 'RaZoR Adult Video Plugin',
                'menu_title'=> 'Adult Video',
                'capability'=> 'manage_options',
                'menu_slug'=> 'rza_plugin',
                'callback'=> array($this->callbacks, 'adminDashboard'),
                'icon_url'=> 'dashicons-format-video',
                'position'=> 110
            )
        );
    }
}