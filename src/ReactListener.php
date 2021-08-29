<?php

declare(strict_types=1);

namespace Chiron\React;

use Chiron\Http\ErrorHandler\HttpErrorHandler;
use Chiron\Core\Dispatcher\AbstractDispatcher;
use Chiron\Http\Http;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Server;
use Throwable;


// Exemple d'un logger pour REACTPHP : https://github.com/WyriHaximus/reactphp-psr-3-stdio


//https://github.com/driftphp/server/blob/70cd306381029ea0f125998dad13938d5fecaf8f/src/Application.php#L117
// TODO : afficher le détail de la request
//https://github.com/driftphp/server/blob/70cd306381029ea0f125998dad13938d5fecaf8f/src/ConsoleRequestMessage.php#L23
// TODO : utiliser un logger qui pointe vers le ConsoleOutput pour afficher du texte dans la console en direct, par exemple pour afficher le détail d'une request
//https://github.com/symfony/console/blob/5.x/Logger/ConsoleLogger.php

final class ReactListener
{
    /** @var callable */
    public $onMessage;

    // TODO : renommer la méthode en run() ou loop() ???
    // TODO : lever une exception si le $this->callback n'est pas initialisé !!!! cad que ce n'est pas un is_callable === true !!!!
    public function listen(): void
    {
        $loop = Factory::create();

        $server = new Server($loop, $this->onMessage);

        //https://github.com/clue/reactphp-buzz/blob/2d4c93be8cba9f482e96b8567916b32c737a9811/tests/FunctionalBrowserTest.php#L34
        //$socket = new \React\Socket\Server(isset($argv[1]) ? $argv[1] : '0.0.0.0:0', $loop);
        $socket = new \React\Socket\Server('127.0.0.1:8080', $loop); // TODO : récupérer le $_SERVER['REACT_PHP'] pour initialiser l'adresse du server !!! Lever une exception si cette donnée n'existe pas ou est vide !!!
        $server->listen($socket);

        //echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;

        //https://github.com/apisearch-io/symfony-react-server/blob/master/src/Application.php#L234
        /*
        $http->on('error', function (\Throwable $e) {
            (new ConsoleException($e, '/', 'EXC', 0))->print();
        });*/

        $loop->run();
    }
}
