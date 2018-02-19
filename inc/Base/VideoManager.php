<?php
/**
 * Created by PhpStorm.
 * @package RzaPornBotPlugin
 * User: razor
 * Date: 18/02/19
 * Time: 21:49
 */

namespace inc\Base;
use WP_REST_Server;
use \inc\Api\Callbacks\VideoCallbacks;

class VideoManager extends BaseController
{
    public $vid_callbacks;

    public function register()
    {
        $this->vid_callbacks = new VideoCallbacks();

        $this->RegisterRoute(array(
            'route'=> 'get',
            'method'=> WP_REST_Server::READABLE,
            'callback'=> 'GetVideoID'
        ));
        $this->RegisterRoute(array(
            'route'=> 'add',
            'method'=> WP_REST_Server::CREATABLE,
            'callback'=> 'AddVideos'
        ));
        $this->RegisterRoute(array(
            'route'=> 'del',
            'method'=> WP_REST_Server::DELETABLE,
            'callback'=> 'DelVideos'
        ));



    }

    /**
     * @param $args
     */
    public function RegisterRoute($args)
    {
        register_rest_route('pornbot/v1','/'.$args['route'], array(
            'method' => $args['method'],
            'callback' => array($this->vid_callbacks, $args['callback'])
        ));
        return;
    }

}