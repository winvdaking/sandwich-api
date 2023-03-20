<?php
namespace orders\models;

class Item extends \Illuminate\Database\Eloquent\Model{

    protected  $table = 'item';
    protected  $primaryKey = 'id';
    public $timestamps = false;
    
    public function order(){
        return $this->belongsTo('orders\models\Order', 'command_id');

    }
}
