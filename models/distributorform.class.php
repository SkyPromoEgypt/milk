<?php

class DistributorForm extends Form
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
                    // Check Payment when adding a new item
                    $paymentType = $_POST['paymentType'];
                    $payment = $_POST['payment'];

                    if($paymentType < 1000000) {
                        $quantity = AnimalFood::read("SELECT * FROM animalfood WHERE id = " . $paymentType, PDO::FETCH_CLASS, "AnimalFood");
                        if($payment > $quantity->quantity) {
                            Messenger::setMessenger("Sorry the store can not cover the food payment");
                            return false;
                        } else {
                            $quantity->quantity -= $payment;
                            $quantity->save();
                            if ($element->save()) {
                                Messenger::setMessenger($this->onSuccess, APP_MESSAGE);
                            } else {
                                Messenger::setMessenger($this->onFailure);
                            }
                            Helper::go($this->_redirectPage);
                        }
                    } else {
                        $settings = Settings::getSettings();
                        if($payment > $settings->safteyBox) {
                            Messenger::setMessenger("Sorry the store can not cover the money payment");
                            return false;
                        } else {
                            $settings->safteyBox -= $payment;
                            $settings->save();
                            if ($element->save()) {
                                Messenger::setMessenger($this->onSuccess, APP_MESSAGE);
                            } else {
                                Messenger::setMessenger($this->onFailure);
                            }
                            Helper::go($this->_redirectPage);
                        }
                    }
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
}