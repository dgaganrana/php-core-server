<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use App\Config\AppLogger;
use Psr\Log\LoggerInterface;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    LoggerInterface::class => function () {
        return AppLogger::getLogger();
    },
]);

return $builder->build();
