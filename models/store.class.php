<?php

class Store extends DatabaseModel
{
    
    public $id;
    
    public $milk;
    
    public $food;
    
    public $onus;
    
    public $forus;
    
    protected $tableName = "store";
    
    protected $fields = array(
            'id',
            'milk',
            'food',
            'onus',
            'forus'
    );
    
    public static function getStore()
    {
        return self::read("SELECT * FROM store WHERE id = 1", PDO::FETCH_CLASS, __CLASS__);
    }
}