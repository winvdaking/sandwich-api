<?php

namespace orders\middlewares;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class ValidatorPostOrderMiddleware
{
    public function __invoke(Request $request, RequestHandler $next): Response
    {
        /**
         * [ client_name => name , client_mail => email, price => montant, status => status,
         * delivery => [ date => "DD-MM-YYYY", time => "HH:MM" ] ]
         */
        $data = $request->getParsedBody();

        $data['delivery'] = date_create($data['delivery']);
        $data['price'] = floatval($data['price']);
        $data['status'] = intval($data['status']);

        try {
            v::key('client_name', v::alnum(' '))
                ->key('client_mail', v::email())
                ->key('price', v::decimal(2))
                ->key('status', v::intType())
                ->key('delivery', v::dateTime())
                ->assert($data);
        } catch(NestedValidationException $e) {
            throw new HttpBadRequestException($request, 'invalid request data : '. $e->getFullMessage());
        }
        
        return $next->handle($request);
    }
}
