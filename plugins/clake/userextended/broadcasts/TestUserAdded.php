<?php namespace Clake\UserExtended\Broadcasts;

use Auth;
use Clake\UserExtended\Classes\UserUtil;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TestUserAdded implements ShouldBroadcast
{
    use SerializesModels;

    public $user;

    public function __construct()
    {
        $this->user = UserUtil::getLoggedInUser();
    }

    public function broadcastOn()
    {
        return new Channel('useradded.hi');
    }
}