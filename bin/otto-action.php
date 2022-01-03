<?php
use AutoRoute\AutoRoute;
use Capsule\Di\Container;
use Capsule\Di\Definitions;

require dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container(
    new Definitions(),
    require dirname(__DIR__) . "/config/providers.php"
);

$namespace = $container->get('otto.namespace') . '\\Sapi\\Http\\Action';
$directory = $container->get('otto.directory') . '/src/Sapi/Http/Action';

$realpath = realpath($directory);
if ($realpath === false) {
    echo "Directory {$directory} not found." . PHP_EOL;
    exit(1);
}

$verb = $argv[1] ?? null;
if ($verb === null) {
    echo "Please pass an HTTP verb as the first argument." . PHP_EOL;
    exit(1);
}

$path = $argv[2] ?? null;
if ($path === null) {
    echo "Please pass a URL path as the second argument." . PHP_EOL;
    exit(1);
}

$domain = $argv[3] ?? null;
if ($path === null) {
    echo "Please pass a Domain subclass as the third argument." . PHP_EOL;
    exit(1);
}

// ---

$autoRoute = new AutoRoute(
    namespace: $namespace,
    directory: $realpath,
    method: '__invoke',
    suffix: '',
    wordSeparator: '-',
);

$creator = $autoRoute->getCreator();

$template = dirname(__DIR__) . '/resources/action.tpl';

[$file, $code] = $creator->create(
    $verb,
    $path,
    file_get_contents($template)
);

$code = strtr($code, ['{DOMAIN}' => $domain]);

echo $file . PHP_EOL;
if (file_exists($file)) {
    echo "Already exists; not overwriting." . PHP_EOL;
    exit(1);
}

$dir = dirname($file);
if (! is_dir($dir)) {
    mkdir($dir, 0777, true);
}

file_put_contents($file, $code);

// NEXT: CREATE THE ACTION TEMPLATE

$mid = 'src/Sapi/Http/Action/';
$pos = strpos($file, $mid);
$len = strlen($mid) + $pos;

$file = $container->get('otto.directory')
    . '/resources/responder/html/action/'
    . substr($file, $len);

echo $file . PHP_EOL;
if (file_exists($file)) {
    echo "Already exists; not overwriting." . PHP_EOL;
    exit(1);
}

$dir = dirname($file);
if (! is_dir($dir)) {
    mkdir($dir, 0777, true);
}

file_put_contents($file, "Template for <code>{$verb} {$path}</code>" . PHP_EOL);
exit(0);
