<?php

class AccountingFarmerForm extends Form
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
                    
                    // Get the farmer
                    $farmer = Farmer::read(
                            "SELECT * FROM farmers WHERE id = " .
                                     $element->farmer_id, PDO::FETCH_CLASS, 
                                    'Farmer');
                    
                    // If payment is animal food get an instance of the selected type
                    if ($element->payment != 1) {
                        $animalfood = AnimalFood::read(
                                "SELECT * FROM animalfood WHERE id = " .
                                         $element->animalfood_id, 
                                        PDO::FETCH_CLASS, 'AnimalFood');
                        $paid = $element->paid;
                        $element->paid *= $animalfood->sellprice;
                        $animalfood->quantity -= $paid; 
                    }
                    
                    if($farmer->tohim > 0) {
                        $farmer->tohim -= $element->paid;
                        if($farmer->tohim < 0) {
                            $farmer->onhim = abs($farmer->tohim);
                            $farmer->tohim = 0;
                        }
                    } else {
                        $farmer->onhim += $element->paid;
                    }
                    
                    if ($element->save()) {
                        $farmer->save();
                        if(isset($animalfood)) $animalfood->save();
                        Messenger::setMessenger($this->onSuccess, APP_MESSAGE);
                    } else {
                        Messenger::setMessenger($this->onFailure);
                    }
                    Helper::go($this->_redirectPage);
                }
                break;
            case "delete":
                if ($this->_itemObject) {
                    // Get the farmer
                    $farmer = Farmer::read(
                            "SELECT * FROM farmers WHERE id = " .
                            $this->_itemObject->farmer_id, PDO::FETCH_CLASS,
                            'Farmer');
                    
                    if($farmer->tohim > 0 && $farmer->onhim == 0) {
                        $farmer->tohim += $this->_itemObject->paid;
                    } elseif($farmer->tohim == 0 && $farmer->onhim >0) {
                        $farmer->onhim -= $this->_itemObject->paid;
                        if($farmer->onhim <= 0) {
                            $farmer->tohim += abs($farmer->onhim);
                            $farmer->onhim = 0;
                        }
                    }
                    
                    if ($element->payment != 1) {
                        $animalfood = AnimalFood::read(
                                "SELECT * FROM animalfood WHERE id = " .
                                $this->_itemObject->animalfood_id,
                                PDO::FETCH_CLASS, 'AnimalFood');
                        $animalfood->quantity += $paid;
                    }
                    
                    if ($this->_itemObject->delete()) {
                        $animalfood->save();
                        $farmer->save();
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