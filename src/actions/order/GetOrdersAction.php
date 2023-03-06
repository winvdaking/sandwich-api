<?php
namespace lbs\order\Action\Order;
use lbs\order\services\utils\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
final class GetOrdersAction{
    public function __invoke(Request $request,
                             Response $response , array $args): Response{
        $orderServive = new OrderService();
        $orders = $orderServive->getOrders();
        $data = [
            'type' => 'collection',
            'count' => count($orders),
            'orders' => $orders
        ];
        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(202);  // withHeader content-type => pour choisir le type de retour de l'erreur.
        $response->getBody()->write(json_encode($data));
        return $response;

    }
}