<?php

namespace frontoffice\actions\validate;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class GetValidateAction
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        if (!$request->hasHeader('Authorization')) {
            return $this->generateAuthentificationError($response);
        }

        $h = $request->getHeader('Authorization')[0];

        $tokenEncode = sscanf($h, "Bearer %s")[0];


        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(200);
        $response->getBody()->write(json_encode($user));

        return $response;

    }

    private function generateAuthentificationError(Response $response, string $message = "no authorization header present"): Response
    {
        $data = [
            "type" => "error",
            "error" => 401,
            "message" => $message
        ];

        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(401);
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}
