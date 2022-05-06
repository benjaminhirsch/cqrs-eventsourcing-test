<?php

declare(strict_types=1);

namespace App;

use App\Domain\AggregateRepository;
use App\Domain\CommandBus;
use App\Domain\EventBus;
use App\Domain\QueryBus;
use App\Factory\CommandBusFactory;
use App\Factory\EventBusFactory;
use App\Factory\QueryBusFactory;
use App\Infrastructure\Handler\Command\CreateAccount;
use Laminas\Di\InjectorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Messenger\MessageBus;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'aliases' => [
                AggregateRepository::class => Infrastructure\BuildingRepository::class
            ],
            'invokables' => [],
            'factories' => array_merge($this->getGeneratedFactories(), [
                CommandBus::class => CommandBusFactory::class,
                QueryBus::class => QueryBusFactory::class,
                EventBus::class => EventBusFactory::class,
            ]),
            'delegators' => [
                InjectorInterface::class => [
                    InjectorDecoratorFactory::class,
                ],
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }

    /**
     * @return array<mixed>
     */
    private function getGeneratedFactories(): array
    {
        // The generated factories.php file is compatible with
        // laminas-servicemanager's factory configuration.
        // This avoids using the abstract AutowireFactory, which
        // improves performance a bit since we spare some lookups.

        /**
         * @psalm-suppress MissingFile
         */
        if (file_exists(__DIR__ . '/../../AppAoT/factories.php')) {
            return include __DIR__ . '/../../AppAoT/factories.php';
        }

        return [];
    }
}
