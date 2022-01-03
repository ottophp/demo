<?php
return [
    new Otto\OttoProvider(
        directory: dirname(__DIR__, 2),
        namespace: __PROJECT__::CLASS,
    ),
    new Otto\Infra\InfraProvider(),
    new Otto\Sapi\Cli\CliProvider(),
];
