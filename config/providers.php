<?php
$namespace = __PROJECT__::CLASS;
$directory = dirname(__DIR__);

return [
    new Otto\OttoProvider(
        directory: $directory,
        namespace: $namespace,
    ),
    new Otto\Sapi\Http\HttpProvider(
        format: 'html',
        layout: 'layout:main',
        helpers: [],
    ),
];
