<?php

class AnimalFoodForm extends Form
{
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
                    $element->created = date("Y-m-d H:i:s");
                    if ($element->save()) {
                        $type = AnimalFood::read("SELECT * FROM animalfood WHERE id = $element->cat_id", PDO::FETCH_CLASS, 'AnimalFood');
                        $type->quantity += $element->quantity;
                        $type->save();
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
                    $oldQuantity = $this->_itemObject->quantity;
                    foreach ($this->_requiredAttributes as $attribute) {
                        $this->_itemObject->$attribute = $_POST[$attribute];
                    }
                    $type = AnimalFood::read("SELECT * FROM animalfood WHERE id = " . $this->_itemObject->cat_id, PDO::FETCH_CLASS, 'AnimalFood');
                    if ($this->_itemObject->quantity > $oldQuantity) {
                        $type->quantity += $this->_itemObject->quantity;
                        $type->save();
                    } else {
                        if(($type->quantity - $this->_itemObject->quantity) < 0) {
                            Messenger::setMessenger("Sorry you can not edit this item because the quantity will be below zero");
                            return false;
                        } else {
                            $type->quantity -= $this->_itemObject->quantity;
                            $type->save();
                        }
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
                    $type = AnimalFood::read("SELECT * FROM animalfood WHERE id = " . $this->_itemObject->cat_id, PDO::FETCH_CLASS, 'AnimalFood');
                    $quantity = $this->_itemObject->quantity;
                    if(($type->quantity - $quantity) < 0) {
                        Messenger::setMessenger("Sorry you can not edit this item because the quantity will be below zero");
                        return false;
                    } else {
                        $type->quantity -= $this->_itemObject->quantity;
                        $type->save();
                    }
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
}