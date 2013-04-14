<?php

class AccountingSupplierForm extends Form
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
                    $supplier = Supplier::read(
                            "SELECT * FROM suppliers WHERE id = " .
                                     $element->supplier_id, PDO::FETCH_CLASS, 
                                    'Supplier');
                    $supplier->tohim -= $element->paid;
                    if ($element->save()) {
                        $supplier->save();
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
                    $oldPaid = $this->_itemObject->paid;
                    foreach ($this->_requiredAttributes as $attribute) {
                        $this->_itemObject->$attribute = $_POST[$attribute];
                    }
                    $supplier = Supplier::read(
                            "SELECT * FROM suppliers WHERE id = " .
                            $this->_itemObject->supplier_id, PDO::FETCH_CLASS,
                            'Supplier');
                    if($oldPaid > $this->_itemObject->paid) {
                        $supplier->tohim += $oldPaid - $this->_itemObject->paid;
                        if ($this->_itemObject->save()) {
                            $supplier->save();
                            Messenger::setMessenger($this->onSuccess, APP_MESSAGE);
                        } else {
                            Messenger::setMessenger($this->onFailure);
                        }
                        Helper::go($this->_redirectPage);
                    } elseif($oldPaid < $this->_itemObject->paid) {
                        $supplier->tohim -= $this->_itemObject->paid- $oldPaid;
                        if ($this->_itemObject->save()) {
                            $supplier->save();
                            Messenger::setMessenger($this->onSuccess, APP_MESSAGE);
                        } else {
                            Messenger::setMessenger($this->onFailure);
                        }
                        Helper::go($this->_redirectPage);
                    }
                }
                break;
            case "delete":
                if ($this->_itemObject) {
                    $supplier = Supplier::read(
                            "SELECT * FROM suppliers WHERE id = " .
                            $this->_itemObject->supplier_id, PDO::FETCH_CLASS,
                            'Supplier');
                    $supplier->tohim += $this->_itemObject->paid;
                    if ($this->_itemObject->delete()) {
                        $supplier->save();
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