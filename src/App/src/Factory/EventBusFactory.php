<?php

declare(strict_types=1);

namespace App\Factory;

use App\Domain\EventBus;
use App\Domain\Exception\InvalidConfig;
use App\Domain\Exception\MissingService;
use Psr\Container\ContainerInterface;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

final class EventBusFactory
{
    public function __invoke(ContainerInterface $container): EventBus
    {
        if(!$container->has('config')) {
            throw MissingService::create('Missing config!');
        }

        $config = $container->get('config');

        if(!isset($config[EventBus::class])) {
            throw InvalidConfig::create(sprintf('Missing %s config key in  container config!', EventBus::class));
        }

        return new \App\Infrastructure\EventBus(new MessageBus([
            new HandleMessageMiddleware(new HandlersLocator(
                array_map(static fn(array $handlerClasses) =>
                    array_map(static fn(string $handlerClass) => $container->get($handlerClass), $handlerClasses),
                        $config[EventBus::class]
                    )
            ))
        ]));
    }
}