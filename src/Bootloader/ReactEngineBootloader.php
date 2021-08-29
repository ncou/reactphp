<?php

declare(strict_types=1);

namespace Chiron\React\Bootloader;

use Chiron\Application;
use Chiron\Core\Container\Bootloader\AbstractBootloader;
use Chiron\Injector\FactoryInterface;
use Chiron\React\ReactEngine;

final class ReactEngineBootloader extends AbstractBootloader
{
    public function boot(Application $application, FactoryInterface $factory): void
    {
        $application->addEngine($factory->build(ReactEngine::class));
    }
}
