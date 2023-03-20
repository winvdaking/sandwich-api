<?php
namespace order\models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model{

    protected  $table ='commande';
    protected string  $idColumn = 'id';
    public $timestamps = true;
    protected $keyType = 'string';
    public $incrementing = false;

    public function items()
    {
        return $this->hasMany('order\models\Item','command_id');

    }

}