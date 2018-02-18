<?php
/*
 * @package RzaPlugin
 */
namespace inc\Base;

class rzaActivate{

    public static function activate()
    {
        /*
        $settings = array(
            'rza_player_width' => '745',
            'rza_player_height' => '500',
            'rza_customfield_link' => 'link',
            'rza_customfield_guid' => 'rza_guid',
            'rza_customfield_duration' => 'duration',
            'rza_customfield_rate' => 'rate',
            'rza_customfield_thumb' => 'thumb',
            'rza_customfield_embed_code' => 'embed_code',
            'rza_title_template' => '{title}',
            'rza_content_template' => '{embed_code}',
            'get_thumb' => '1',
        );
        foreach ( $settings as $k => $v )
        {
            update_option($k, $v);
        }*/
        // generated a CPT
        //flush rewrite rules
        flush_rewrite_rules();
        $thumbs_dir = WP_CONTENT_DIR."/uploads/rza-thumbs/";
        if (!file_exists($thumbs_dir)){
            if (!mkdir($thumbs_dir,0775, true) && !is_dir($thumbs_dir)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $thumbs_dir));
            }
        }
        $default_managers = array();
        $default_settings = array();
        if (!get_option('rza_plugin_managers')){
            update_option('rza_plugin_managers', $default_managers);
        }

        if (!get_option('rza_plugin_settings')){
            update_option('rza_plugin_settings', $default_settings);
        }

    }
}
