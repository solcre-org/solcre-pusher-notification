<?php

namespace Solcre\EmailSchedule;

use Solcre\PusherNotification\Service\Factory\PusherServiceFactory;
use Solcre\PusherNotification\Service\PusherService;

return [
    'service_manager' => [
        'factories' => [
            PusherService::class => PusherServiceFactory::class
        ],
    ]
];
