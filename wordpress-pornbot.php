<?php
/*
@package RzaPornBotPlugin

Plugin Name: Wordpress PornBot
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Multi Adult video poster
Version: 1.0.0
Author: RaZoR
Author URI: http://URI_Of_The_Plugin_Author
License: GPL version 3 or later
Text Domain: razor-adult-plugin

--------------------------------------------------------------------
Wordpress PornBot - Adult Video Multi-Poster
Copyright (C) 2018  RaZoR

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
--------------------------------------------------------------------
*/

defined('ABSPATH') or die('Hey, you can\'t access here without permission');

if (file_exists(__DIR__.'/vendor/autoload.php')){
    require_once __DIR__.'/vendor/autoload.php';
}

function activate_rza_pornbot_plugin()
{
    inc\Base\rzaActivate::activate();
}
register_activation_hook(__FILE__, 'activate_rza_pornbot_plugin');

function deactivate_rza_pornbot_plugin()
{
    inc\Base\rzaDeactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_rza_pornbot_plugin');

if (class_exists('inc\\init')){
    inc\init::register_services();
}
