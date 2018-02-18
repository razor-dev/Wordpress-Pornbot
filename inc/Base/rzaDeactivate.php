<?php
/*
 * @package RzaPlugin
 */
namespace inc\Base;

class rzaDeactivate{

    public static function deactivate()
    {
        //flush rewrite rules
        flush_rewrite_rules();
    }
}