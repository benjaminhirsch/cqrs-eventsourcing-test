<?php

declare(strict_types=1);

use App\Factory\Database\PdoFactory;

return [
    'dependencies' => [
        'factories' => [
            PDO::class => PdoFactory::class
        ]
    ],
    'database' => [
        'default' => [
            'adapter' => 'pgsql',
            'dbname' => 'app',
            'host' => 'localhost',
            'port' => 5432,
            'user' => 'app',
            'pass' => 'app',
        ],
    ],
];
