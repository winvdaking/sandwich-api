<?php
namespace order\services\utils;

use order\models\Order;

final class OrderService {
    public function getOrders(){
        $query = Order::select('id', 'mail as client_mail', 'created_at as order_date', 'montant as total_amount')->get();

        try {
            return $query->ToArray();
        } catch (\Throwable $o) {
            throw new \ErrorException("orders $o not found !");
        }
    }

    public function getOrdersById(int $id){
        $query = Order::select('id', 'mail as client_mail','nom as client_name', 'created_at as order_date', 'livraison as delivery_date','montant as total_amount')->where('id', '=', $id);

        try {
            return $query->firstOrFail()->ToArray();

        } catch (\Throwable $o) {
            throw new \ErrorException("order $o not found !");
        }
    }

    public function orderUpdate(int $id,array $data):void{
    $query = Order::update()
    }

    private function toRow(array $order) : array{
        return [
            'livraison' => $order['livraison'],
            'nom' => $order['nom'],
            'mail' => $order['mail'],

        ]
    }


}