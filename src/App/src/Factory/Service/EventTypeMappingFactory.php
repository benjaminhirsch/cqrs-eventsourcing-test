<?php

declare(strict_types=1);

namespace App\Factory\Service;

use App\Domain\Exception\InvalidConfig;
use App\Domain\Exception\MissingService;
use App\Domain\Service\EventTypeMapping;
use Psr\Container\ContainerInterface;

final class EventTypeMappingFactory
{
    public function __invoke(ContainerInterface $container): EventTypeMapping
    {
        if(!$container->has('config')) {
            throw MissingService::create('Missing config!');
        }

        $config = $container->get('config');

        if(!isset($config['eventTypeMapping'])) {
            throw InvalidConfig::create(sprintf('Missing %s config key in  container config!', 'eventTypeMapping'));
        }

        return new EventTypeMapping($config['eventTypeMapping']);
    }
}