<?php
declare(strict_types=1);

namespace __PROJECT__\Domain;

use Throwable;

abstract class App
{
    final public function run(mixed ...$args) : Payload
    {
        try {
            return ($this)(...$args);
        } catch (Throwable $e) {
            return Payload::error([
                'class' => get_class($this),
                'exception' => (string) $e,
                'arguments' => $args,
            ]);
        }
    }
}
