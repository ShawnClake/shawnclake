<?php namespace Clake\Pusher\Classes;

use Clake\UserExtended\Classes\UserUtil;
use Config;
use October\Rain\Support\Facades\Config as cfig;


class Pusher
{

    private $key;
    private $secret;
    private $appid;
    private $options = [];
    private $pusher;


    public static function init()
    {
        $o = new static();
        $o->key = Config::get('clake.pusher::key');
        $o->secret = Config::get('clake.pusher::secret');
        $o->appid = Config::get('clake.pusher::appid');
        array_push($o->options, 'encrypted', Config::get('clake.pusher::encrypted'));
        $o->pusher = new \Pusher($o->key, $o->secret, $o->appid, $o->options);
        return $o;
    }

    public function get()
    {
        return $this->pusher;
    }

    public function auth($channelName, $socketId)
    {
        if(UserUtil::getLoggedInUser())
        {
            if(substr($channelName, 0, 7) == "private")
                echo $this->pusher->socket_auth($channelName, $socketId);
            else if(substr($channelName, 0, 8) == "presence")
                echo $this->pusher->presence_auth($channelName, $socketId, UserUtil::getLoggedInUser()->id, UserUtil::getLoggedInUser()->toArray());
            else
            {
                header('', true, 403);
                echo "Forbidden";
            }
        }
        else
        {
            header('', true, 403);
            echo "Forbidden";
        }

        return $this;
    }

    public function trigger($channel, $event, $data)
    {
        $this->pusher->trigger($channel, $event, $data, post('socket_id'));
        return $this;
    }

}