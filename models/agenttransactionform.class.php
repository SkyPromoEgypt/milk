<?php

class AgentTransactionForm extends Form
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
                    $store = Store::getStore();
                    $agent = Agent::read(
                            'SELECT * FROM agents WHERE id = ' .
                                     $element->agent_id, PDO::FETCH_CLASS, 
                                    'Agent');
                    if (($store->milk - $element->quantity) < 0) {
                        Messenger::setMessenger(
                                "عفوا المخزن لا يغطي الكمية المطلوبة");
                        return false;
                    } else {
                        $store->milk -= $element->quantity;
                        $agent->onhim += $element->price * $element->quantity;
                        if ($element->save()) {
                            $store->save();
                            $agent->save();
                            Messenger::setMessenger($this->onSuccess, 
                                    APP_MESSAGE);
                        } else {
                            Messenger::setMessenger($this->onFailure);
                        }
                        Helper::go($this->_redirectPage);
                    }
                }
                break;
            case "edit":
                if ($this->isSubmitted('submit') &&
                         $this->hasRequiredFields($this->_requiredFields)) {
                    $oldQuantity = $this->_itemObject->quantity;
                    $oldPrice = $this->_itemObject->price;
                    
                    $store = Store::getStore();
                    $agent = Agent::read(
                            'SELECT * FROM agents WHERE id = ' .
                                     $this->_itemObject->agent_id, 
                                    PDO::FETCH_CLASS, 'Agent');
                    foreach ($this->_requiredAttributes as $attribute) {
                        $this->_itemObject->$attribute = $_POST[$attribute];
                    }
                    
                    if ($this->_itemObject->quantity < $this->_itemObject->lost) {
                        Messenger::setMessenger(
                                "الكمية المطلوبة لا يمكن ان تكون اقل من الكمية المستلمة");
                        return false;
                    }
                    
                    if ($this->_itemObject->quantity < $oldQuantity) {
                        // modify store
                        $store->milk += $oldQuantity -
                                 $this->_itemObject->quantity;
                        // modify agent
                        $added = $agent->onhim - ($oldQuantity * $oldPrice);
                        $agent->onhim = $added;
                        $agent->onhim += $this->_itemObject->quantity *
                                 $this->_itemObject->price;
                        var_dump($agent, $this->_itemObject->price);
                        $agent->save();
                        $store->save();
                        if ($this->_itemObject->save()) {
                            Messenger::setMessenger($this->onSuccess, 
                                    APP_MESSAGE);
                        } else {
                            Messenger::setMessenger($this->onFailure);
                        }
                        Helper::go($this->_redirectPage);
                    } elseif ($this->_itemObject->quantity > $oldQuantity) {
                        // modify store
                        if (($store->milk - $this->_itemObject->quantity) < 0) {
                            Messenger::setMessenger(
                            "عفوا المخزن لا يغطي الكمية المطلوبة");
                            return false;
                        }
                        $store->milk -= $this->_itemObject->quantity -
                                 $oldQuantity;
                        // modify agent
                        $added = $agent->onhim - ($oldQuantity * $oldPrice);
                        $agent->onhim = $added;
                        $agent->onhim += $this->_itemObject->quantity *
                                 $this->_itemObject->price;
                        
                        $store->save();
                        $agent->save();
                        if ($this->_itemObject->save()) {
                            Messenger::setMessenger($this->onSuccess, 
                                    APP_MESSAGE);
                        } else {
                            Messenger::setMessenger($this->onFailure);
                        }
                        Helper::go($this->_redirectPage);
                    } elseif ($oldPrice != $this->_itemObject->price) {
                        // modify agent
                        $added = $agent->onhim - ($oldQuantity * $oldPrice);
                        $agent->onhim = $added;
                        $agent->onhim += $this->_itemObject->quantity *
                        $this->_itemObject->price;
                        $agent->save();
                        if ($this->_itemObject->save()) {
                            Messenger::setMessenger($this->onSuccess,
                            APP_MESSAGE);
                        } else {
                            Messenger::setMessenger($this->onFailure);
                        }
                        Helper::go($this->_redirectPage);
                    } else {
                        $this->_itemObject->save();
                        Helper::go($this->_redirectPage);
                    }
                }
                break;
            case "delete":
                if ($this->_itemObject) {
                    $store = Store::getStore();
                    $agent = Agent::read(
                            'SELECT * FROM agents WHERE id = ' .
                                     $this->_itemObject->agent_id, 
                                    PDO::FETCH_CLASS, 'Agent');
                    $store->milk += $this->_itemObject->quantity;
                    $agent->onhim -= $this->_itemObject->quantity *
                             $this->_itemObject->price;
                    $agent->save();
                    $store->save();
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