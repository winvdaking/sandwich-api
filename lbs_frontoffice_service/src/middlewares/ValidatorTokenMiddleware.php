<?php

namespace frontoffice\middlewares;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpUnauthorizedException;
use GuzzleHttp\Client;

class ValidatorTokenMiddleware
{
    public function __invoke(Request $request, RequestHandler $next): Response
    {

        if (!$request->hasHeader('Authorization')) {
            throw new HttpUnauthorizedException($request, 'Authorization header not found');
        }

        $client = new Client(['base_uri' => 'https://api.auth.local/v1/']);

        $response = $client->request('GET', '/validate', [
            'headers' => [
                'Authorization' => $request->getHeader('Authorization')[0],
            ]
        ]);

        var_dump($response->getBody());
        
        return $next->handle($request);
    }
}