<?php
declare(strict_types=1);

namespace App\Core;

use Psr\Log\LoggerInterface;

abstract class BaseController
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
