<?php
return [
    new Otto\OttoProvider(
        directory: dirname(__DIR__),
        namespace: __PROJECT__::CLASS,
    ),
    new Otto\Sapi\Http\HttpProvider(
        format: 'html',
        layout: 'layout:main',
        helpers: [],
    ),
];
