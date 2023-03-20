<?php
namespace orders\models;

class Order extends \Illuminate\Database\Eloquent\Model{

    protected  $table = 'commande';
    protected string $idColumn = 'id';
    public $timestamps = true;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [];

    public function items(){
        return $this->hasMany('orders\models\Item','command_id');

    }
}
