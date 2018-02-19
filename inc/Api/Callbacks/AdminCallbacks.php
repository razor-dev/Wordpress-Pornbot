<?php
/*
 * @package RzaPlugin
 */

namespace inc\Api\Callbacks;

use inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
    /**
     * @return mixed
     */
    public function adminDashboard()
    {
        return require("$this->plugin_path/templates/main.php");
    }

    public function settingsPage()
    {
        return require("$this->plugin_path/templates/settings.php");
    }

    public function xVideos()
    {
        return require("$this->plugin_path/templates/xvideos.php");
    }

    public function rzaAdminSection()
    {
        return 'asdasdasd';
    }
}