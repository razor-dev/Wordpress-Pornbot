<?php
/*
 * @package RzaPornBotPlugin
 */

namespace inc\Base;

class BaseController
{
    public $plugin_path;
    public $plugin_url;
    public $plugin;
    public $main_settings = array();
    public $managers = array();

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path($this->dirname_r(__FILE__, 2));
        $this->plugin_url = plugin_dir_url($this->dirname_r(__FILE__, 2));
        $this->plugin = plugin_basename($this->dirname_r(__FILE__, 3)).'/wordpress-pornbot.php';

        $this->main_settings = array(
            'rza_player_width' => array('Width:', 'rza_player_settings_dimension', 'text'),
            'rza_player_height' => array('Height:', 'rza_player_settings_dimension', 'text'),
            'rza_customfield_link' => array('Link of video:', 'rza_player_settings_custom_fields', 'text'),
            'rza_customfield_duration' => array('Duration of video:', 'rza_player_settings_custom_fields', 'text'),
            'rza_customfield_rate' => array('Rating of video:', 'rza_player_settings_custom_fields', 'text'),
            'rza_customfield_thumb' => array('Thumbnail of video:', 'rza_player_settings_custom_fields', 'text'),
            'rza_customfield_embed_code' => array('Embed code of video:', 'rza_post_template_setting', 'text'),
            'rza_customfield_title_template' => array('Title Template:', 'rza_post_template_setting', 'text'),
            'rza_customfield_content_template' => array('Content template:', 'rza_post_template_setting', 'textarea' ),
            'rza_get_thumb' => array('Download thumbnail', 'rza_player_settings_get_thumbnail', 'checkbox', 'ui-toggle')
        );

        $this->managers = array(
            'xVideos' => 'xVideos Module',
        );
    }

    private function dirname_r($path, $count=1){
        if ($count > 1){
            return dirname($this->dirname_r($path, --$count));
        }
        return dirname($path);
    }

    public function activated($key)
    {
        $option = get_option('rza_plugin_pornbot_managers');
        return isset($option[$key]) ? $option[$key]  : false;
    }
}