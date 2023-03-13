<?php
namespace orders\models;

class Order extends \Illuminate\Database\Eloquent\Model{

    protected  $table = 'commande';
    protected  $idColumn = 'id';
    public $timestamps = true;
    protected $keyType = 'string';
    public $incrementing = false;

    public function items(){
        return $this->hasMany('order\models\Item','id');

    }
}
