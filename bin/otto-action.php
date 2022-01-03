<?php
use Capsule\Di\Container;
use Capsule\Di\Definitions;
use Otto\Domain\App\Action\CreateAction;

require dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container(
    new Definitions(),
    require dirname(__DIR__) . "/config/cli/providers.php"
);

$verb = $argv[1] ?? null;
$path = $argv[2] ?? null;
$domain = $argv[3] ?? null;

$command = $container->get(CreateAction::CLASS);
$payload = ($command)($verb, $path, $domain);
foreach ($payload->getResult()['messages'] ?? [] as $message) {
    echo $message . PHP_EOL;
}

if ($payload->getStatus() === 'CREATED') {
    exit(0);
}

exit(1);
