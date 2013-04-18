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
                    if ($element->quantity < $element->lost) {
                        Messenger::setMessenger(
                                "الكمية المطلوبة لا يمكن ان تكون اقل من الكمية المستلمة");
                        return false;
                    }
                    $element->created = date("Y-m-d H:i:s");
                    $supplier = Supplier::read(
                            "SELECT * FROM suppliers WHERE id = $element->supplier_id", 
                            PDO::FETCH_CLASS, 'Supplier');
                    $type = AnimalFood::read(
                            "SELECT * FROM animalfood WHERE id = $element->cat_id", 
                            PDO::FETCH_CLASS, 'AnimalFood');
                    $element->price = $type->buyprice;
                    if ($element->save()) {
                        $type->quantity += $element->quantity;
                        $supplier->tohim += $element->quantity * $element->price;
                        $supplier->save();
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
                    if ($this->_itemObject->quantity < $this->_itemObject->lost) {
                        Messenger::setMessenger(
                        "الكمية المطلوبة لا يمكن ان تكون اقل من الكمية المستلمة");
                        return false;
                    }
                    $supplier = Supplier::read(
                            "SELECT * FROM suppliers WHERE id = " .
                                     $this->_itemObject->supplier_id, 
                                    PDO::FETCH_CLASS, 'Supplier');
                    $type = AnimalFood::read(
                            "SELECT * FROM animalfood WHERE id = " .
                                     $this->_itemObject->cat_id, 
                                    PDO::FETCH_CLASS, 'AnimalFood');
                    if ($this->_itemObject->quantity > $oldQuantity) {
                        $type->quantity += $this->_itemObject->quantity -
                                 $oldQuantity;
                        $supplier->tohim -= $oldQuantity *
                                 $this->_itemObject->price;
                        $supplier->tohim += $this->_itemObject->quantity *
                                 $this->_itemObject->price;
                        $supplier->save();
                        $type->save();
                    } else {
                        if (($type->quantity - $this->_itemObject->quantity) < 0) {
                            Messenger::setMessenger(
                                    "Sorry you can not edit this item because the quantity will be below zero");
                            return false;
                        } else {
                            $type->quantity -= $oldQuantity -
                                     $this->_itemObject->quantity;
                            $supplier->tohim -= $oldQuantity *
                                     $this->_itemObject->price;
                            $supplier->tohim += $this->_itemObject->quantity *
                                     $this->_itemObject->price;
                            $supplier->save();
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
                    $type = AnimalFood::read(
                            "SELECT * FROM animalfood WHERE id = " .
                                     $this->_itemObject->cat_id, 
                                    PDO::FETCH_CLASS, 'AnimalFood');
                    $quantity = $this->_itemObject->quantity;
                    $supplier = Supplier::read(
                            "SELECT * FROM suppliers WHERE id = " .
                                     $this->_itemObject->supplier_id, 
                                    PDO::FETCH_CLASS, 'Supplier');
                    if (($type->quantity - $quantity) < 0) {
                        Messenger::setMessenger(
                                "Sorry you can not edit this item because the quantity will be below zero");
                        return false;
                    } else {
                        $type->quantity -= $this->_itemObject->quantity;
                        $supplier->tohim -= $this->_itemObject->quantity *
                                 $this->_itemObject->price;
                        $supplier->save();
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