<?php
namespace order\services\utils;

use order\models\Item;
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

    public function getOrdersById(string $id , ?string $embed=null):array{
        $query = Order::select('id', 'mail as client_mail','nom as client_name', 'created_at as order_date', 'livraison as delivery_date','montant as total_amount')->where('id', '=', $id);

        if ($embed ==='items'){
           $query = $query->with('items');

        }
        try {
            return $query->firstOrFail()->ToArray();

        } catch (\Throwable $o) {
            throw new \ErrorException("order $o not found !");
        }
    }

    public function getOrderItems(string $id):array{
       $items = Item::select('id','uri','libelle as name','tarif as price','quantite as quatity')->where('command_id', '=', $id)->get();
        return $items->ToArray();
    }

    public function orderUpdate(int $id,array $data):void{
    $query = Order::update();
    }

    private function toRow(array $order) : array{
        return [
            'livraison' => $order['livraison'],
            'nom' => $order['nom'],
            'mail' => $order['mail'],
            'montant' => $order['montant'],
        ];
    }


}