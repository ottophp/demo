<?php
declare(strict_types=1);

namespace {NAMESPACE};

use __PROJECT__\Domain;
use Otto\Sapi\Http\Responder\ActionResponder;
use Sapien\Request;
use Sapien\Response;

class {CLASS}
{
    public function __construct(
        protected Request $request,
        protected Domain\{DOMAIN} $domain,
        protected ActionResponder $responder,
    ) {
    }

    public function __invoke({PARAMETERS}) : Response
    {
        $payload = $this->domain->run({PARAMETERS});
        return $this->responder($this, $payload);
    }
}
