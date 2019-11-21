<?php

namespace Solcre\PusherNotification\Exception;

use Exception;

class PusherNotificationException extends Exception
{
    protected $additional = [];

    public function __construct($message = '', $code = 0, $additional = [])
    {
        $this->additional = $additional;
        parent::__construct($message, $code);
    }

    /**
     * @return array
     */
    public function getAdditional(): array
    {
        return $this->additional;
    }
}
