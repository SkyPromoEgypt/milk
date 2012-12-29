<?php

class Settings extends DatabaseModel
{

    public $id;

    public $atitle;

    public $etitle;

    public $facebookToken;

    public $facebookUser;

    public $twitter;

    public $status;
    
    public static $settings;

    protected $tableName = 'settings';

    protected $fields = array(
            "atitle",
            "etitle",
            "facebookToken",
            "facebookUser",
            "twitter",
            "status"
    );
    
    public static function getSettings()
    {
        if(null === self::$settings) {
            self::$settings = self::read("SELECT * FROM settings LIMIT 1", PDO::FETCH_CLASS, __CLASS__);
        }
        return self::$settings;
    }
}