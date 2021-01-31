<?php

declare(strict_types=1);

namespace Chiron\React\Bootloader;

use Chiron\Core\Container\Bootloader\AbstractBootloader;
use Chiron\Console\Console;
use Chiron\React\Command\ReactServeCommand;

final class ReactCommandBootloader extends AbstractBootloader
{
    public function boot(Console $console): void
    {
        $console->addCommand(ReactServeCommand::getDefaultName(), ReactServeCommand::class);
    }
}
