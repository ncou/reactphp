<?php

declare(strict_types=1);

namespace Chiron\React;

use Chiron\Http\ErrorHandler\HttpErrorHandler;
use Chiron\Core\Engine\AbstractEngine;
use Chiron\Http\Http;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Server;
use Throwable;

final class ReactEngine extends AbstractEngine
{
    public function isActive(): bool
    {
        return PHP_SAPI === 'cli' && env('REACT_PHP') !== null;
    }

    // TODO utiliser l'événement ->on('request', $callable) plutot que de passer le callable en paramétre du serveur !!! exemple ci dessous !!!!
    //https://stackoverflow.com/questions/24310817/using-reactphp-for-sockets-in-php-port-stops-listening
    // TODO : gérer les erreurs !!!!! => https://github.com/apisearch-io/symfony-react-server/blob/master/src/Application.php#L234
    // TODO : autre exemple : https://github.com/driftphp/server/blob/c5b2b530e446c52804f074138aa16ba9a252fc89/src/Application.php#L178
    // TODO : exemple avec un affichage de texte dans la console :      https://github.com/NigelGreenway/reactive-slim/blob/master/src/Server.php#L156
    protected function perform(ReactListener $react, Http $http): void
    {
        // Callable used when a new request event is received.
        $react->onMessage = [$http, 'handle'];
        // Listen (loop wainting a request) and Emit the response.
        $react->listen();
    }
}
