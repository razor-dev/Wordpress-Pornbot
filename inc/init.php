<?php
/*
 * @package RzaPornBotPlugin
 */

namespace inc;

final class init
{
    /**
     * Store all the classes inside an array
     * @return array Full list of classes
     */
    public static function get_services()
    {
        return [
            pages\Dashboard::class,
            Base\enqueue::class,
            Base\SettingsLinks::class,
            Base\Settings::class,
            Base\Validator::class,
            Base\Curl::class,
        ];
    }

    /**
     * Loop through the classes, initialize them, and call the register() method if it exists
     * @return
     */
    public static function register_services()
    {
        foreach (self::get_services() as $class)
        {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')){
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     * @param $class classes form the services array
     * @return mixed instance new instance
     */
    private static function instantiate($class)
    {
        return new $class();
    }

}
