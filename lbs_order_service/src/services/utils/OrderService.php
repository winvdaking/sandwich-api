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
        }catch (ModelNotFoundException $e) {
            throw new OrderExceptionNotFound("orders not found");
        }
    }

    public function getOrdersById(string $id)
    {
        $query = Order::select('id', 'mail as client_mail','nom as client_name', 'created_at as order_date', 'livraison as delivery_date','montant as total_amount')->where('id', '=', $id);

        try {
            return $query->firstOrFail()->toArray();
        }catch (ModelNotFoundException $e) {
            throw new OrderExceptionNotFound("order $id not found");
        }
    }

    public function orderUpdate(int $id,array $data): void
    {
        $query = Order::update();
    }

    public function postOrder(array $data): Order
    {
        $order = new Order;
        $order->id = uniqid();
        $order->nom = $data['client_name'];
        $order->mail = $data['client_mail'];
        $order->montant = $data['price'];
        $order->status = $data['status'];
        $order->livraison = $data['delivery'];

        $order->save();

        return $order;
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
