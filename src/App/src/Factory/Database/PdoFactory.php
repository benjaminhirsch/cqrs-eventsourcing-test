<?php

declare(strict_types=1);

namespace App\Factory\Database;

use App\Domain\Exception\InvalidConfig;
use App\Domain\Exception\Runtime;
use PDO;
use Psr\Container\ContainerInterface;


use function sprintf;

final class PdoFactory
{
    public function __invoke(ContainerInterface $container): PDO
    {
        if (! $container->has('config')) {
            throw Runtime::create('Missing application config!');
        }

        $config                  = $container->get('config');
        $defaultConnectionConfig = $config['database']['default'] ?? null;
        if ($defaultConnectionConfig === null) {
            throw InvalidConfig::create('Missing default connection configuration entry in config');
        }

        if (! isset($defaultConnectionConfig['adapter'])) {
            throw InvalidConfig::create('Missing adapter in configuration');
        }

        if (! isset($defaultConnectionConfig['dbname'])) {
            throw InvalidConfig::create('Missing dbname in configuration');
        }

        if (! isset($defaultConnectionConfig['host'])) {
            throw InvalidConfig::create('Missing host in configuration');
        }

        if (! isset($defaultConnectionConfig['port'])) {
            throw InvalidConfig::create('Missing port in configuration');
        }

        if (! isset($defaultConnectionConfig['user'])) {
            throw InvalidConfig::create('Missing user in configuration');
        }

        if (! isset($defaultConnectionConfig['pass'])) {
            throw InvalidConfig::create('Missing password (pass) in configuration');
        }

        return new PDO(sprintf(
            '%s:host=%s;dbname=%s',
            $defaultConnectionConfig['adapter'],
            $defaultConnectionConfig['host'],
            $defaultConnectionConfig['dbname'],
        ), $defaultConnectionConfig['user'], $defaultConnectionConfig['pass'], $defaultConnectionConfig['options'] ?? null);
    }
}
