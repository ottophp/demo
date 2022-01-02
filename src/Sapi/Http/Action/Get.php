<?php
namespace __PROJECT__\Sapi\Http\Action;

use __PROJECT__\Domain\App\Hello\SayHello;
use Otto\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class Get
{
    public function __construct(
        protected Request $request,
        protected SayHello $app,
        protected ActionResponder $responder,
    ) {
    }

    public function __invoke(string $name = 'world') : Response
    {
        $payload = $this->app->run($name);
        return ($this->responder)($this, $payload);
    }
}
