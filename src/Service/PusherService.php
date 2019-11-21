<?php

namespace Solcre\PusherNotification\Service;

use Pusher\Pusher;
use Solcre\PusherNotification\Entity\PusherNotification;
use Solcre\PusherNotification\Exception\PusherNotificationException;
use Throwable;

class PusherService
{
    private $pusherClient;
    private $pusherConfig;

    /**
     * PusherService constructor.
     * @param Pusher $pusherClient
     * @param array $pusherConfig
     */
    public function __construct(Pusher $pusherClient, array $pusherConfig)
    {
        $this->pusherClient = $pusherClient;
        $this->pusherConfig = $pusherConfig;
    }

    public function trigger(PusherNotification $pusherNotification)
    {
        try {
            return $this->pusherClient->trigger($pusherNotification->getChannel(), $pusherNotification->getEvent(), $pusherNotification->getData());
        } catch (Throwable $t) {
            throw $t;
        }
    }

    public function getChannel(string $channelName, array $channelExtraInfo): string
    {
        $channel = $this->pusherConfig['CHANNELS'][$channelName];
        if (empty($channel)) {
            throw new PusherNotificationException('Channel not found', 422);
        }
        if (! empty($channelExtraInfo)) {
            $this->processChannelExtraInfo($channel, $channelExtraInfo);
        }
        return $channel;
    }

    private function processChannelExtraInfo(string &$channel, array $channelExtraInfo): void
    {
        foreach ($channelExtraInfo as $key => $item) {
            if (strpos($channel, $key)) {
                $channel = str_replace($key, $item, $channel);
            }
        }
    }

    public function getEvent(string $eventName): string
    {
        $event = $this->pusherConfig['EVENTS'][$eventName];
        if (empty($event)) {
            throw new PusherNotificationException('Event not found', 422);
        }
        return $event;
    }
}
