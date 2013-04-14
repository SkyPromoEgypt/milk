<?php

class Distribution extends DatabaseModel
{

    public $id;

    public $farmer_id;

    public $quantity;

    public $price;

    public $thetime;

    public $created;

    protected $tableName = "distribution";

    protected $fields = array(
            'id',
            'farmer_id',
            'quantity',
            'price',
            'thetime',
            'created'
    );

    public static function hasTodayEntry ($farmer, $time = true)
    {
        $dayTime = ($time) ? 1 : 2;
        $today = date("Y-m-d");
        $sql = "SELECT * FROM distribution WHERE farmer_id = $farmer AND created = '$today' AND thetime = $dayTime LIMIT 1";
        $result = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        return $result ? true : false;
    }

    public static function getMilkQuantities ($time = true)
    {
        $dayTime = ($time) ? 1 : 2;
        $today = date("Y-m-d");
        $sql = "SELECT SUM(quantity) as q FROM distribution WHERE created = '$today' AND thetime = $dayTime";
        $result = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        return $result ? $result->q : 0;
    }
    
    public static function getMilkQuantitiesForThisMonth ($time = true)
    {
        $dayTime = ($time) ? 1 : 2;
        $startDate = date("Y") . '-' . date("m") . '-1';
        $endDate = date("Y") . '-' . date("m") . '-31';
        $sql = "SELECT SUM(quantity) as q FROM distribution WHERE created >= '$startDate' AND created <= '$endDate' AND thetime = $dayTime";
        $result = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        return $result ? $result->q : 0;
    }

    public static function getMilkQuantityForFarmer ($farmer, $time = true)
    {
        $dayTime = ($time) ? 1 : 2;
        $today = date("Y-m-d");
        $sql = "SELECT id, quantity, price FROM distribution WHERE farmer_id = $farmer AND created = '$today' AND thetime = $dayTime LIMIT 1";
        $result = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        return $result ? $result : 0;
    }

    public static function renderForControl ($sql, $className)
    {
        $items = Farmer::read($sql, PDO::FETCH_CLASS, "Farmer");
        
        $mainUrl = '/' . Helper::getView();
        
        $message = 'Do you really want to delete this item ?';
        
        $js = 'if(confirm(\'' . $message .
                 '\')) { return true; } else { return false; }';
        
        $output = '<table class="mws-table">
                            <thead>
                                <tr>
                                    <th>سعر خاص</th>
                                    <th>كمية المساء</th>    
                                    <th>سعر خاص</th>
                                    <th>كمية الصبح</th>
                                    <th>اسم المزارع</th>
                                    <th>مسلسل</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td><input style="width:40px" type="text" name="eprice[]"></td>
                    <td><input style="width:40px" type="text" name="equantity[]"></td>
                    <td><input style="width:40px" type="text" name="mprice[]"></td>
                    <td><input style="width:40px" type="text" name="mquantity[]"></td>
                    <td>' . $items->name . '</td>
                    <td>1<input type="hidden" name="farmer[]" value="' .
                     $items->id . '"></td>
                </tr>';
        } else {
            $i = 1;
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td><input style="width:40px" type="text" name="eprice[]"></td>
                    <td><input style="width:40px" type="text" name="equantity[]"></td>
                    <td><input style="width:40px" type="text" name="mprice[]"></td>
                    <td><input style="width:40px" type="text" name="mquantity[]"></td>
                    <td>' . $item->name . '</td>
                    <td>' . $i ++ .
                         '<input type="hidden" name="farmer[]" value="' .
                         $item->id . '"></td>
                </tr>   ';
            }
        }
        $output .= '</tbody></table>';
        return $output;
    }

    public static function renderForEdit ($sql, $className)
    {
        $today = date("Y-m-d");
        $items = Farmer::read($sql, PDO::FETCH_CLASS, $className);
        $mainUrl = '/' . Helper::getView();
        
        $output = '<table class="mws-table">
                            <thead>
                                <tr>
                                    <th width="21%">تعديل</th>
                                    <th>السعر</th>
                                    <th>كمية المساء</th>
                                    <th>السعر</th>
                                    <th>كمية الصباح</th>
                                    <th>اسم المزارع</th>
                                    <th>مسلسل</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $morningDetails = self::getMilkQuantityForFarmer($item->id);
            $nightDetails = self::getMilkQuantityForFarmer($item->id, false);
            $output .= '<tr class="gradeX">
                    <td>1</td>
                    <td>' . $items->name . '</td>
                    <td>' . $morningDetails->quantity . '</td>
                    <td>' . $morningDetails->price . '</td>
                    <td>' . $nightDetails->quantity . '</td>
                    <td>' . $nightDetails->price . '</td>
                    <td>
                    	<a href="' . $mainUrl . '/edit/' .
                     $morningDetails->id . '">تعديل الصباح</a> | <a href="' .
                     $mainUrl . '/edit/' . $nightDetails->id . '">تعديل المساء</a>		
                   	</td>
                </tr>';
        } else {
            $i = 1;
            foreach ($items as $item) {
                $morningDetails = self::getMilkQuantityForFarmer($item->id);
                $nightDetails = self::getMilkQuantityForFarmer($item->id, false);
                $output .= '
                <tr class="gradeX">
                    <td>
                    	<a href="' . $mainUrl . '/edit/' . $morningDetails->id .
                         '" style="text-decoration: none;" class="mws-tooltip-n mws-button green">تعديل الصباح</a>  <a href="' .
                         $mainUrl . '/edit/' . $nightDetails->id . '" style="text-decoration: none;" class="mws-tooltip-n mws-button red">تعديل المساء</a>		
                   	</td>
                    <td>' . $nightDetails->price . '</td>
                    <td>' . $nightDetails->quantity . '</td>
                    <td>' . $morningDetails->price . '</td>
                    <td>' . $morningDetails->quantity . '</td>
                    <td>' . $item->name . '</td>
                    <td>' . $i ++ . '</td>
                </tr>';
            }
        }
        $output .= '</tbody></table>';
        return $output;
    }
}
