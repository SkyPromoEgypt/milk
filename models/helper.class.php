<?php

class Helper
{   
    public static function getView()
    {
        return $_GET['view'] ? $_GET['view'] : 'index';
    }

    public static function render ()
    {
        $view = self::getView();
        $filename = VIEWS_PATH . $view . '.view.php';
        if (file_exists($filename)) {
            require_once $filename;
        } else {
            require_once VIEWS_PATH . '404.view.php';
        }
    }
    
    public static function mailto ($email, $subject, $message)
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: PEAK Control System' . "\r\n";
        if (mail($email, '=?UTF-8?B?' . base64_encode($subject) . '?=', $message, 
                $headers)) {
            return true;
        }
    }
    
    public static function go($page)
    {
        header("Location: " . $page);
    }
    
    public static function urlContains($pattern)
    {
        return preg_match("/$pattern/i", $_SERVER['REQUEST_URI']);
    }
    
    public static function dump($array)
    {
        echo '<pre>' .  print_r($array, true) . '</pre>';
    }
    
    public static function wrap($wrappedItem, $wrapper)
    {
        return $wrapper . $wrappedItem . $wrapper;
    }
}