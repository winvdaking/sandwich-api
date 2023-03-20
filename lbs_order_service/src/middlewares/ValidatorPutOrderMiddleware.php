<?php

namespace orders\middlewares;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class ValidatorPutOrderMiddleware
{
    public function __invoke(
        Request $request,
        RequestHandler $next): Response {

        $data = $request->getParsedBody();

        try {
            v::key( 'client_name', v::alnum(' ','.'))
                ->key('client_mail', v::email())
                ->key('delivery', v::dateTime('Y-m-d H:i:s'))
                ->assert($data);
        } catch( NestedValidationException $e) {
            throw
            new HttpBadRequestException($request,
                'invalid request data : '. $e->getMessage());
        }
        return $next->handle($request);
    }
}
