<?php

declare(strict_types=1);

namespace Chiron\React\Dispatcher;

use Chiron\Http\Http;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;

final class ReactDispatcher extends AbstractDispatcher
{
    /** @var Http */
    private $http;

    /**
     * {@inheritdoc}
     */
    // TODO : virer le paramétre Environment et utiliser directement la fonction globale getenv()
    public function canDispatch(): bool
    {
        //return true;
        //return php_sapi_name() === 'cli' && $this->env->get('REACT_PHP') !== null;
        return php_sapi_name() === 'cli' && env('REACT_PHP') !== null;
    }

    protected function perform(Http $http): void
    {
        $this->http = $http;
        $this->createServer();
    }

    // TODO utiliser l'événement ->on('request', $callable) plutot que de passer le callable en paramétre du serveur !!! exemple ci dessous !!!!
    //https://stackoverflow.com/questions/24310817/using-reactphp-for-sockets-in-php-port-stops-listening
    private function createServer()
    {
        $loop = Factory::create();

        $server = new Server($loop, function (ServerRequestInterface $request) {
            return $this->http->run($request);
        });

        //$socket = new \React\Socket\Server(isset($argv[1]) ? $argv[1] : '0.0.0.0:0', $loop);
        $socket = new \React\Socket\Server('127.0.0.1:8080', $loop);
        $server->listen($socket);

        echo 'Listening on ' . str_replace('tcp:', 'http:', $socket->getAddress()) . PHP_EOL;

        $loop->run();
    }

    //https://github.com/hunzhiwange/framework/blob/master/src/Leevel/Http/Request.php#L151
    /*
    public function isConsole(): bool
    {
        if ($this->server->get('SERVER_SOFTWARE') === 'swoole-http-server') {
            return false;
        }

        return $this->isRealCli();
    }*/

}
