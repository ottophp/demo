<?php
use Capsule\Di\Container;
use Capsule\Di\Definitions;
use Otto\Sapi\Http\Front;
use Sapien\Response;

try {

    require dirname(__DIR__) . "/vendor/autoload.php";

    $container = new Container(
        new Definitions(),
        require dirname(__DIR__) . "/config/http/providers.php"
    );

    $front = $container->get(Front::CLASS);
    $response = $front();

} catch (Throwable $e) {

    $response = (new Response())
        ->setCode(500)
        ->setHeader('content-type', 'text/plain')
        ->setContent($e);

}

$response->send();
