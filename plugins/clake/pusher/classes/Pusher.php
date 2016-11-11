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
        $auth = true;

        if(!UserUtil::getLoggedInUser())
            $auth = false;

        if(strlen($channelName) > 19 && substr($channelName,8,11) == "userchannel")
            if(!(substr($channelName,19) == UserUtil::getLoggedInUser()->id))
                $auth = false;

        if($auth == true && substr($channelName, 0, 8) == "presence")
            $this->allowPresence($channelName, $socketId);
        else if($auth == true && substr($channelName, 0, 7) == "private")
            $this->allowPrivate($channelName, $socketId);
        else
            $this->reject();

        return $this;
    }

    public function trigger($channel, $event, $data)
    {
        $this->pusher->trigger($channel, $event, $data, post('socket_id'));
        return $this;
    }

    private function reject()
    {
        header('', true, 403);
        echo "Forbidden";
    }

    private function allowPrivate($channelName, $socketId)
    {
        echo $this->pusher->socket_auth($channelName, $socketId);
    }

    private function allowPresence($channelName, $socketId)
    {
        echo $this->pusher->presence_auth($channelName, $socketId, UserUtil::getLoggedInUser()->id, UserUtil::getLoggedInUser()->toArray());

    }

}