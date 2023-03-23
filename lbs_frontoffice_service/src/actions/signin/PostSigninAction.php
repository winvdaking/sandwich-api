<?php

namespace frontoffice\actions\signin;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use GuzzleHttp\Client;

final class PostSigninAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {

        if (!$request->hasHeader('Authorization')) {
            return $this->generateAuthentificationError($response);
        }

        $client = new Client(['base_uri' => 'http://api.auth/v1']);

        $responseApi = $client->request('POST', '/signin', [
            'headers' => [
                'Authorization' => $request->getHeader('Authorization')
            ]
        ]);
        

        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus($responseApi->getStatusCode());
        $response->getBody()->write(json_encode($responseApi->getBody()));

        return $response;
    }

    private function generateAuthentificationError(Response $response): Response
    {
        $data = [
            "type" => "error",
            "error" => 401,
            "message" => "no authorization header present"
        ];

        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(401);
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}
