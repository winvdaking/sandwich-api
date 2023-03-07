<?php
namespace lbs\order\models;
class Order extends \Illuminate\Database\Eloquent\Model{

    protected  $table = 'commande';
    protected  $idColumn = 'id';
    public $timestamps = true;

    public function items(){
        return $this->hasMany('lbs\order\models\Item','id');

    }

}