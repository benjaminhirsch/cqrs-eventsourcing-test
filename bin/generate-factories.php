<?php

declare(strict_types=1);


use Laminas\Di\CodeGenerator\InjectorGenerator;
use Laminas\Di\ConfigInterface;
use Laminas\Di\Definition\RuntimeDefinition;
use Laminas\Di\Resolver\DependencyResolver;
use Psr\Container\ContainerInterface;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;

chdir(__DIR__ . '/../');

require 'vendor/autoload.php';

$container = require 'config/container.php';
assert($container instanceof ContainerInterface);


$directories = [
    __DIR__ . '/../src/App/src/Domain',
    //__DIR__ . '/../src/App/src/Infrastructure',
];

$diConfig = $container->get(ConfigInterface::class);

$resolver = new DependencyResolver(new RuntimeDefinition(), $diConfig);
$resolver->setContainer($container);

$generator = new InjectorGenerator($diConfig, $resolver, 'App\AoT');
$generator->setOutputDirectory(__DIR__ . '/../src/AppAoT');


$astLocator = (new BetterReflection())->astLocator();
$directoriesSourceLocator = new DirectoriesSourceLocator($directories, $astLocator);
$reflector = new DefaultReflector($directoriesSourceLocator);

$generator->generate(array_map(static fn($reflection) => $reflection->getName(), $reflector->reflectAllClasses()));

echo 'Factories successfully generated' . PHP_EOL;
