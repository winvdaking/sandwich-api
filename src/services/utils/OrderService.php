<?php
namespace lbs\order\services\utils;

use lbs\order\models\Order;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
final class OrderService {
    public function getOrders(){
        $query = Order::select('id', 'mail as client_mail', 'created_at as order_date', 'montant as total_amount')->get();

        try {
            return $query->ToArray();
        } catch (\Throwable $o) {
            throw new \ErrorException("orders $o not found !");
        }
    }

    public function getOrdersById($id){
        $query = Order::select('id', 'mail as client_mail','nom as client_name', 'created_at as order_date', 'livraison as delivery_date','montant as total_amount')->where('id', '=', $id);

        try {
            return $query->firstOrFail()->ToArray();

        } catch (\Throwable $o) {
            throw new \ErrorException("order $o not found !");
        }
    }


}