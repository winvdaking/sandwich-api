<?php
namespace order\models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model{

    protected  $table = 'item';
    protected string $idColumn = 'id';
    public $timestamps = false;
    public function order(){
        return $this->belongsTo('order\models\Order', 'command_id');

    }

}