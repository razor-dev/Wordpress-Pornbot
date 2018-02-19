<?php
/*
 * @package RzaPornBotPlugin
 */
namespace inc\Base;

class enqueue extends BaseController
{

    public function register()
    {
        add_action('admin_enqueue_scripts', array($this, 'Enqueue'));
    }

    public function Enqueue()
    {
        wp_enqueue_style('RzaPluginStyle', $this->plugin_url.'assets/rza-pornbot-style.css');
        wp_enqueue_script('RzaPluginStyle', $this->plugin_url.'assets/rza-pornbot-script.js');
    }
}