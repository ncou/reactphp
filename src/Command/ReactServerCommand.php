<?php

declare(strict_types=1);

namespace Chiron\React\Command;

use Chiron\Boot\Environment;
use Chiron\Boot\Directories;
use Chiron\Console\AbstractCommand;
use Chiron\Filesystem\Filesystem;
use Chiron\PublishableCollection;
use Symfony\Component\Console\Input\InputOption;

final class ReactServerCommand extends AbstractCommand
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    protected static $defaultName = 'react:serve';

    protected function configure(): void
    {
        $this->setDescription('React Server.');
    }

    public function perform(Environment $environement, Directories $directories): int
    {

        $_SERVER['REACT_PHP'] = 'true';
        //$_ENV['REACT_PHP'] = 'true';
        //putenv("REACT_PHP=true");

        //$environement->set('REACT_PHP', true);

        include $directories->get('@public/index.php');

        return self::SUCCESS;
    }
}
