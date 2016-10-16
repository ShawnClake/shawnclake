<?php namespace Clake\Pusher\Components;

use Clake\Pusher\Classes\Pusher;
use Cms\Classes\ComponentBase;

class AuthEndpoint extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'AuthEndpoint',
            'description' => 'Provides an endpoint for an API call via Pusher'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $channelName = post('channel_name');
        $socketId = post('socket_id');
        Pusher::init()->auth($channelName, $socketId);
    }

}