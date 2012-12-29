<?php

class Form
{

    private $_requiredFields;

    private $_object;
    
    private $_tableName;

    private $_requiredAttributes;

    private $_redirectPage;

    private $_itemObject;

    private $onSuccess = 'Item successfully saved.';

    private $onFailure = 'Error Saving the item.';

    private $onNotFound = 'Sorry, item doesn\'t exixts';

    public function __construct ($className, $tableName, Array $attributes, 
            Array $requiredFields, $redirectPage)
    {
        $this->_requiredFields = $requiredFields;
        $this->_object = $className;
        $this->_tableName = $tableName;
        $this->_requiredAttributes = $attributes;
        $this->_redirectPage = $redirectPage;
    }

    public function process ()
    {
        switch ($this->getTask()) {
            case "add":
                if ($this->isSubmitted('submit') &&
                         $this->hasRequiredFields($this->_requiredFields)) {
                    $element = new $this->_object();
                    foreach ($this->_requiredAttributes as $attribute) {
                        $element->$attribute = $_POST[$attribute];
                    }
                    if ($element->save()) {
                        Messenger::setMessenger($this->onSuccess, APP_MESSAGE);
                    } else {
                        Messenger::setMessenger($this->onFailure);
                    }
                    Helper::go($this->_redirectPage);
                }
                break;
            case "edit":
                if ($this->isSubmitted('submit') &&
                         $this->hasRequiredFields($this->_requiredFields)) {
                    foreach ($this->_requiredAttributes as $attribute) {
                        $this->_itemObject->$attribute = $_POST[$attribute];
                    }
                    if ($this->_itemObject->save()) {
                        Messenger::setMessenger($this->onSuccess, APP_MESSAGE);
                    } else {
                        Messenger::setMessenger($this->onFailure);
                    }
                    Helper::go($this->_redirectPage);
                }
                break;
            case "delete":
                if ($this->_itemObject) {
                    if ($this->_itemObject->delete()) {
                        Messenger::setMessenger($this->onSuccess, APP_MESSAGE);
                    } else {
                        Messenger::setMessenger($this->onFailure);
                    }
                    Helper::go($this->_redirectPage);
                }
                break;
        }
    }

    public function getTask ()
    {
        return $_GET['task'];
    }

    public function getElement ()
    {
        $id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : null;
        if ($id) {
            $element = call_user_func(array(
                    $this->_object,
                    "read"
            ), "SELECT * FROM " . $this->_tableName . " WHERE id = " . $id, PDO::FETCH_CLASS, 
                    $this->_object);
            if (! $element) {
                Messenger::setMessenger($this->onNotFound);
                Helper::go($this->_redirectPage);
            } else {
                $this->_itemObject = $element;
                return $element;
            }
        }
    }

    public function hasRequiredFields (Array $required)
    {
        foreach ($required as $field => $error) {
            if (empty($_POST[$field])) {
                Messenger::setMessenger('Please fill in the field of ' . $error);
            }
        }
        return ! empty($_SESSION['messenger']) ? false : true;
    }

    public function isSubmitted ($button)
    {
        return (isset($_POST[$button])) ? true : false;
    }

    public static function _e ($field, $object = null)
    {
        echo (is_object($object)) ? $object->$field : $_POST[$field];
    }
}