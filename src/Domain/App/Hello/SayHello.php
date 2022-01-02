<?php
namespace __PROJECT__\Domain\App\Hello;

use __PROJECT__\Domain\App;
use __PROJECT__\Domain\Payload;

class SayHello extends App
{
    public function __invoke(string $name) : Payload
    {
        return Payload::found([
            'name' => $name,
        ]);
    }
}
