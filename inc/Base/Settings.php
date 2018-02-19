<?php
/**
 * Created by PhpStorm.
 * User: razor
 * Date: 2/6/2018
 * Time: 7:56 PM
 */

namespace inc\Base;
use \inc\Api\SettingsApi;
use \inc\Base\BaseController;
use \inc\Api\Callbacks\AdminCallbacks;
use \inc\Api\Callbacks\ManagerCallbacks;

class Settings extends BaseController
{
    public $subpages = array();
    public $callbacks;
    public $callbacks_mngr;
    public $settings;

    public function register()
    {
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->callbacks_mngr = new ManagerCallbacks();

        $this->setSubPages();

        $this->setSettings();
        $this->setSection();
        $this->setFields();
        //add_action('init', array($this, 'activate'));
        $this->settings->addSubPages($this->subpages)->register();


    }

    public function activate()
    {

    }

    public function setSubPages()
    {
        $this->subpages = array(
            array(
                'parent_slug'=> 'rza_pornbot_plugin',
                'page_title'=> 'Adult Video Settings',
                'menu_title'=> 'Settings',
                'capability'=> 'manage_options',
                'menu_slug'=> 'rza_pornbot_settings',
                'callback'=> array($this->callbacks, 'settingsPage')
            )
        );
    }

    public function setSettings()
    {

        $args = array(
            array(
                'option_group' => 'rza_pornbot_options_group',
                'option_name' => 'rza_pornbot_plugin_settings',
                'callback' => array($this->callbacks, 'rzaCustomSettings')
            ),
            array(
                'option_group' => 'rza_pornbot_managers_settings',
                'option_name' => 'rza_pornbot_plugin_managers',
                'callback' => array($this->callbacks_mngr, 'checkboxSanitize')
            )
        );
        $this->settings->setSettings($args);
    }

    public function setSection()
    {
        $args = array(
            array(
                'id' => 'rza_pornbot_managers_settings_section',
                'title' => 'Adult Video Manager Settings',
                'callback' => array($this->callbacks_mngr, 'adminSectionManager'),
                'page' => 'rza_settings_managers'
            ),
            array(
                'id' => 'rza_player_settings_dimension',
                'title' => 'Player dimension setting',
                'callback' => array($this->callbacks, 'rzaAdminSection'),
                'page' => 'rza_pornbot_settings'
            ),
            array(
                'id' => 'rza_player_settings_custom_fields',
                'title' => 'Name of custom fields:',
                'callback' => array($this->callbacks, 'rzaAdminSection'),
                'page' => 'rza_pornbot_settings'
            ),
            array(
                'id' => 'rza_player_settings_get_thumbnail',
                'title' => 'Download thumbnail to the server?',
                'callback' => array($this->callbacks, 'rzaAdminSection'),
                'page' => 'rza_pornbot_settings'
            ),
            array(
                'id' => 'rza_post_template_setting',
                'title' => 'Post Template setting',
                'callback' => array($this->callbacks, 'rzaAdminSection'),
                'page' => 'rza_pornbot_settings'
            ),
        );

        $this->settings->setSection($args);
    }

    public function setFields()
    {
        $args = array();

        foreach ($this->main_settings as $key => $value)
        {
            $args[] = array(
                'id' => $key,
                'title' => $value[0],
                'callback' => array($this->callbacks_mngr, 'FieldGen'),
                'page' => 'rza_pornbot_settings',
                'section' => $value[1],
                'args' => array(
                    'option_name' => 'rza_pornbot_plugin_settings',
                    'label_for' => $key,
                    'type'      => $value[2],
                    'class' => isset($value[3]) ? $value[3] : '',
                )
            );
        }

        foreach ($this->managers as $key => $value)
        {
            $args[] = array(
                'id' => $key,
                'title' => $value,
                'callback' => array($this->callbacks_mngr, 'FieldGen'),
                'page' => 'rza_pornbot_settings_managers',
                'section' => 'rza_managers_settings_section',
                'args' => array(
                    'option_name' => 'rza_pornbot_plugin_managers',
                    'label_for' => $key,
                    'type'      => 'checkbox',
                    'class' => 'ui-toggle',
                )
            );
        }
        $this->settings->setField($args);
    }
}