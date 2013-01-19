<?php

class Settings extends DatabaseModel
{

    public $id;

    public $safteyBox;

    public static $settings;

    protected $tableName = 'settings';

    protected $fields = array(
            "safteyBox"
    );
    
    public static function getSettings()
    {
        if(null === self::$settings) {
            self::$settings = self::read("SELECT * FROM settings LIMIT 1", PDO::FETCH_CLASS, __CLASS__);
        }
        return self::$settings;
    }
}