<?php
namespace lbs\order\models;

class Item extends \Illuminate\Database\Eloquent\Model{

    protected  $table = 'item';
    protected  $idColumn = 'id';
    public $timestamps = false;
    public function order(){
        return $this->belongsTo('lbs\order\models\Order', 'command_id');

    }

}