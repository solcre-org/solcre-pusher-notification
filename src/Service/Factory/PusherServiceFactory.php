<?php

namespace Solcre\PusherNotification\Service\Factory;

use Interop\Container\ContainerInterface;
use Pusher\Pusher;
use Pusher\PusherException;
use RuntimeException;
use Solcre\PusherNotification\Service\PusherService;
use Zend\ServiceManager\Factory\FactoryInterface;

class PusherServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        if (! isset($config['zfr_pusher'])) {
            throw new RuntimeException(
                'No config was found for ZfrPusher. Did you copy the `zfr_pusher.local.php` file to your autoload folder?'
            );
        }
        try {
            $pusher = new Pusher($config['zfr_pusher']['key'], $config['zfr_pusher']['secret'], $config['zfr_pusher']['app_id'], ['cluster' => $config['zfr_pusher']['cluster']]);
        } catch (PusherException $pe) {
            throw new RuntimeException($pe->getMessage());
        }
        return new PusherService($pusher, $config['pusher']);
    }
}
