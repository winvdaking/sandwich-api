<?php

namespace orders\middlewares;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;



use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class ValidatorOrderMiddleware
{
    public function __invoke(
        Request $request,
        RequestHandler $next): Response {
        /**
         * [ client_name => name , client_mail => email
         * delivery => [ date => "DD-MM-YYYY", time => "HH:MM" ] ]
         */
        $data = $request->getParsedBody();
        try {
            v::key( 'client_name', v::alnum(' '))
                ->key('client_mail', v::email())
                ->key('delivery', v::key('date', v::Date('d-m-Y'))
                    ->key('time', v::Time('G:i')))
                ->assert($data);
        } catch( NestedValidationException $e) {
            throw
            new HttpBadRequestException($request,
                'invalid request data : '. $e->getFullMessage());
        }
        return $next->handle($request);
    }
}