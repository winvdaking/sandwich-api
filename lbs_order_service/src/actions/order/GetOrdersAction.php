<?php
namespace order\actions\order;
use order\services\utils\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

final class GetOrdersAction{
    public function __invoke(Request $request,
                             Response $response , array $args): Response{
        $uri = $request->getUri()->getPath();

        $orderServive = new OrderService();
        $orders = $orderServive->getOrders();
    $orders_data = [];
    $routeParser = RouteContext::fromRequest($request)->getRouteParser();
    foreach ($orders as $order){
        $orders_data[] = ['order' => [$order,
            'links' => ['self' => ['href' => $routeParser->urlFor('order', ['id'=>$order['id']])
            ]]]];}


        $data = [
            'type' => 'collection',
            'count' => count($orders),
            'orders' =>
               $orders_data

        ];
        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(200);
        $response->getBody()->write(json_encode($data));
        return $response;

    }
}