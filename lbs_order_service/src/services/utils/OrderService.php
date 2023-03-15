<?php

namespace orders\services\utils;

use orders\models\Order;
use orders\errors\exceptions\OrderExceptionNotFound;
use Illuminate\Database\Eloquent\ModelNotFoundException;


final class OrderService {

    public function getOrders(): Array
    {
        $query = Order::select('id', 'mail as client_mail', 'created_at as order_date', 'montant as total_amount')->get();

        try {
            return $query->toArray();
        }catch (\Throwable $e) {
            throw new OrderExceptionNotFound("orders not found");
        }
    }

    public function getOrdersById(string $id)
    {
        $query = Order::select('id', 'mail as client_mail','nom as client_name', 'created_at as order_date', 'livraison as delivery_date','montant as total_amount')->where('id', '=', $id);

        try {
            return $query->firstOrFail()->toArray();
        }catch (\Throwable $e) {
            throw new OrderExceptionNotFound("order $id not found");
        }
    }

    public function orderUpdate(string $id,array $data):void{

        try {
            $order = Order::find($id)->firstOrFail();
        }catch (ModelNotFoundException $e){
            throw new OrderExceptionNotFound($e->getMessage());
        }


        $order->nom = $data['client_name'];
        $order->mail = $data['client_mail'];
        $order->livraison = $data['delivery'];
        $order->save();

    }

    private function toRow(array $order): array
    {
        return [
            'livraison' => $order['livraison'],
            'nom' => $order['nom'],
            'mail' => $order['mail'],

        ];
    }
}
