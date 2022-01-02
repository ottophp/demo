<?php
$namespace = __PROJECT__::CLASS;
$directory = dirname(__DIR__);

return [
    new Otto\Sapi\Http\HttpProvider(
        namespace: $namespace,
        directory: $directory,
        format: 'html',
        layout: 'layout:main',
        helpers: [],
    ),
];
