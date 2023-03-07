<?php
namespace lbs\order\Action\Order;
use lbs\order\services\utils\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
final class GetOrderByIdAction{
    public function __invoke(Request $request,
                             Response $response , array $args): Response{
        $orderServive = new OrderService();
        $order = $orderServive->getOrdersById($args['id']);
        $data = [
            'type' => 'resource',
            'order' => $order
        ];
        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(202);  // withHeader content-type => pour choisir le type de retour de l'erreur.
        $response->getBody()->write(json_encode($data));
        return $response;

    }
}