<?php
/*
 * @package RzaPlugin
 */

namespace inc\Base;
use \inc\Api\SettingsApi;
use \inc\Api\Callbacks\AdminCallbacks;

class xVideos extends BaseController
{
    public $subpages = array();
    public $callbacks;
    public $settings;
    public function register()
    {


        if (!$this->activated('xVideos')) return;
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->setSubPages();
        $this->settings->addSubPages($this->subpages)->register();
    }

    public function setSubPages()
    {
        $this->subpages = array(
            array(
                'parent_slug' => 'rza_plugin',
                'page_title' => 'xVideos Video Grabber',
                'menu_title' => 'xVideos',
                'capability' => 'manage_options',
                'menu_slug' => 'rza_xVideos',
                'callback' => array($this->callbacks, 'xVideos')
            )
        );
    }

}