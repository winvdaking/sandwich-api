<?php
namespace orders\services\utils;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use orders\models\Order;
use Slim\Exception\HttpNotFoundException;

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

        try {
            $order = Order::find($id)->firstOrFail();
        }catch (ModelNotFoundException $e){
            //Todo implementer la bone Exception {OrderExceptionNotFound()}
            throw new \ErrorException($e->getMessage());
        }


        $order->update([
            'client_name' => $data['client_name'],
            'client_mail' => $data['client_mail'],
            'delivery' => $data['delivery']
        ]);
    }

    private function toRow(array $order) : array{
        return [
            'livraison' => $order['livraison'],
            'nom' => $order['nom'],
            'mail' => $order['mail'],
        ];
    }


}