<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use TemirkhanN\Venture\Game\App;
use TemirkhanN\Venture\Game\IO\HttpInput;
use TemirkhanN\Venture\Game\IO\Printer;

ini_set('memory_limit','10M');

require_once __DIR__ . '/../bootstrap.php';

$di = require __DIR__ .'/di.php';

/** @var App $app */
$app = $di->get(App::class);
/** @var Printer $output */
$output = $di->get(Printer::class);

function serveStaticFiles(ServerRequestInterface $request): ?Response {
    $path = $request->getUri()->getPath();
    if (!str_starts_with($path, '/assets/images/') &&
        !str_starts_with($path, '/favicon.ico')
    ) {
        return null;
    }

    $filePath = __DIR__ . preg_replace('#\.{2,}#', '', $path);
    if (!file_exists($filePath)) {
        $response = Response::plaintext('');
        $response->withStatus(404);

        return $response;
    }

    return new Response(200, ['Content-Type' => 'image/png'], file_get_contents($filePath));
}

$http = new React\Http\HttpServer(function (ServerRequestInterface $request) use ($app, $output) {
    if (($staticFile = serveStaticFiles($request)) !== null) {
        return $staticFile;
    }

    $input = new HttpInput(json_decode((string) $request->getBody(), true) ?? []);
    $app->run($input);

    return Response::html($output->flush());
});

$http->on('error', function (Exception $e) {
    echo PHP_EOL . $e->getMessage() . PHP_EOL;
    if ($e->getPrevious() !== null) {
        echo $e->getPrevious()->getMessage() . PHP_EOL;
    }
});

$socket = new React\Socket\SocketServer('172.17.0.2:8080');
$http->listen($socket);

echo 'server is running';
