<?php
namespace orders\models;

class Paiement extends \Illuminate\Database\Eloquent\Model{

    protected  $table = 'item';
    protected string $idColumn = 'id';
    public $timestamps = true;
}
