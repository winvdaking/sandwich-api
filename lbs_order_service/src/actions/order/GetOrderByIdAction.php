<?php
namespace order\actions\order;
use order\services\utils\OrderService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

final class GetOrderByIdAction{
    public function __invoke(Request $request,
                             Response $response , array $args): Response{
        $embed = $request->getQueryParams()['embed']?? null;
echo ($embed);
        $orderServive = new OrderService();
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $order = $orderServive->getOrdersById($args['id'],$embed);
      //  print_r($order['items']);
        $data = [
            'type' => 'resource',
            'order' => $order,
            'links' => [
                'items' =>[
                    'href' => $routeParser->urlFor('items', ['id'=>$order['id']])
                ],
                'self' =>[
                'href' => $routeParser->urlFor('order', ['id'=>$order['id']])
            ]
        ]
        ];
        $response = $response->withHeader('Content-type', 'application/json;charset=utf-8')->withStatus(200);
        $response->getBody()->write(json_encode($data));
        return $response;

    }
}