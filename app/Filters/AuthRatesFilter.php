<?php

namespace App\Filters;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Shield\Filters\AuthRates;

class AuthRatesFilter extends AuthRates
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$request instanceof IncomingRequest) {
            return;
        }

        $throttler = service('throttler');

        if ($throttler->check(md5($request->getIPAddress()), 10, MINUTE, 10) === false) {
            return service('response')->setStatusCode(
                429,
                lang('Auth.throttled', [$throttler->getTokenTime()])
            );
        }
    }
}
