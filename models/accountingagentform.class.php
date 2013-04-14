<?php

class AccountingAgentForm extends Form
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
                    $agent = Agent::read(
                            "SELECT * FROM agents WHERE id = " .
                                     $element->agent_id, PDO::FETCH_CLASS, 
                                    'Agent');
                    $agent->onhim -= $element->paid;
                    if ($element->save()) {
                        $agent->save();
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
                    $agent = Agent::read(
                            "SELECT * FROM agents WHERE id = " .
                            $this->_itemObject->agent_id, PDO::FETCH_CLASS,
                            'Agent');
                    if($oldPaid > $this->_itemObject->paid) {
                        $agent->onhim += $oldPaid - $this->_itemObject->paid;
                        if ($this->_itemObject->save()) {
                            $agent->save();
                            Messenger::setMessenger($this->onSuccess, APP_MESSAGE);
                        } else {
                            Messenger::setMessenger($this->onFailure);
                        }
                        Helper::go($this->_redirectPage);
                    } elseif($oldPaid < $this->_itemObject->paid) {
                        $agent->onhim -= $this->_itemObject->paid- $oldPaid;
                        if ($this->_itemObject->save()) {
                            $agent->save();
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
                    $agent = Agent::read(
                            "SELECT * FROM agents WHERE id = " .
                            $this->_itemObject->agent_id, PDO::FETCH_CLASS,
                            'Agent');
                    $agent->onhim += $this->_itemObject->paid;
                    if ($this->_itemObject->delete()) {
                        $agent->save();
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