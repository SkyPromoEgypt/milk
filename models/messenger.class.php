<?php

class Messenger
{

    public static function setMessenger ($message, $type = APP_ERROR)
    {
        switch ($type) {
            case 1:
                $_SESSION['messenger'][] = '<p class="error">' . $message .
                         '</p>';
                break;
            case 2:
                $_SESSION['messenger'][] = '<p class="warning">' . $message .
                         '</p>';
                break;
            case 3:
                $_SESSION['messenger'][] = '<p class="info">' . $message .
                         '</p>';
                break;
            case 4:
                $_SESSION['messenger'][] = '<p class="message">' . $message .
                         '</p>';
                break;
        }
    }
    
    public static function appMessenger()
    {
        $messages = $_SESSION['messenger'];
        unset($_SESSION['messenger']);
        echo $messages ? implode('', $messages) : '';
    }
}