<?php

declare(strict_types=1);

namespace TemirkhanN\Venture\Game\Action\Launcher;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Loop;
use React\Http\HttpServer;
use React\Http\Message\Response;
use React\Socket\SocketServer;
use TemirkhanN\Venture\Game\App;
use TemirkhanN\Venture\Game\IO\HttpInput;
use TemirkhanN\Venture\Game\IO\InputInterface;
use TemirkhanN\Venture\Game\IO\Printer;

class WebLauncher
{
    public function __construct(private readonly App $app, private readonly Printer $printer) {}

    public function run(string $onHost): void
    {
        if ($this->app->isRunning()) {
            throw new \RuntimeException('Application is already running');
        }

        $http = new HttpServer(\Closure::fromCallable([$this, 'handleRequest']));
        $http->on('error', function (Exception $e) {
            echo PHP_EOL . $e->getMessage() . PHP_EOL;
            if ($e->getPrevious() !== null) {
                echo $e->getPrevious()->getMessage() . PHP_EOL;
            }
        });

        $socket = new SocketServer($onHost);

        $http->listen($socket);
    }

    private function serveStaticFile(string $path): Response {
        $filePath = APP_DIR . '/' . trim(preg_replace('#\.{2,}#', '', $path), '/');
        if (!file_exists($filePath)) {
            $response = Response::plaintext('');
            $response->withStatus(404);

            return $response;
        }

        $contentType = 'image/x-icon';
        if (!str_starts_with($path, '/favicon.ico')) {
            $contentType = 'image/png';
        }

        return new Response(200, ['Content-Type' => $contentType], file_get_contents($filePath));
    }

    private function readInput(ServerRequestInterface $request): InputInterface
    {
        return new HttpInput(json_decode((string) $request->getBody(), true) ?? []);
    }

    private function handleRequest(ServerRequestInterface $request): ?Response
    {
        if (array_key_exists('exit', $request->getQueryParams())) {
            echo 'Stopping...' . PHP_EOL;

            Loop::addTimer(1, [Loop::class, 'stop']);

            return Response::plaintext('Application stopped');
        }

        $path = $request->getUri()->getPath();
        if (str_starts_with($path, '/assets/images/') ||
            str_starts_with($path, '/favicon.ico')
        ) {
            return $this->serveStaticFile($path);
        }

        $input = $this->readInput($request);
        $this->app->run($input);

        return Response::html($this->printer->flush());
    }
}
