<?php

namespace orders\actions\order;


use orders\services\utils\OrderService;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class PutOrderByIdAction
{
    public function __invoke(Request $request,
                             Response $response , array $args): Response{
        $orderService = new OrderService();

        $body = $request->getParsedBody();

        try {
            $orderService->orderUpdate($args['id'], $body);
        }catch ( \ErrorException $e){
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        return $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(204);
    }
}