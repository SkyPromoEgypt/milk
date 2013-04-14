<?php

class AccountingFarmer extends DatabaseModel
{

    public $id;

    public $farmer_id;

    public $paid;

    public $paymnet;

    public $animalfood_id;

    public $created;

    protected $tableName = "accountingfarmer";

    protected $fields = array(
            'id',
            'farmer_id',
            'paid',
            'payment',
            'animalfood_id',
            'created'
    );

    public static function renderForControl ($sql, $className)
    {
        $items = self::read($sql, PDO::FETCH_CLASS, $className);
        
        $mainUrl = '/' . Helper::getView();
        
        $message = 'Do you really want to delete this item ?';
        
        $js = 'if(confirm(\'' . $message .
                 '\')) { return true; } else { return false; }';
        
        $output = '<div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span class="mws-i-24 i-table-1">قائمة بمدفوعاتنا للمزارعين</span>
                    </div>
                    <div class="mws-panel-body">
                        <div class="mws-panel-toolbar top clearfix">
                            <ul>
                                <li><a class="mws-ic-16 ic-add" href="' .
                 $mainUrl .
                 '/add">اضافة</a></li>
                                <li><a class="mws-ic-16 ic-cross" id="deleteLink" href="' .
                 $mainUrl . '/delete" onclick="' . $js . '">حذف</a></li>
                            </ul>
                        </div>
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th>تاريخ الدفع</th>
                                    <th>نوع العلف</th>
                                    <th>نوع الدفع</th>
                                    <th>المبلغ المدفوع</th>
                                    <th>اسم المزارع</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $farmer = Farmer::read(
                    "SELECT * FROM farmers WHERE id = $items->farmer_id", 
                    PDO::FETCH_CLASS, 'Farmer');
            if ($items->payment == 1) {
                $animalFood = '';
            } else {
                $animalFood = AnimalFood::read(
                        "SELECT * FROM animalfood WHERE id = $items->animalfood_id", 
                        PDO::FETCH_CLASS, 'AnimalFood')->name;
            }
            $output .= '<tr class="gradeX">
                    <td>' . $items->created . ' </td>
                    <td>' . $animalFood . ' </td>
                    <td>' . (($items->payment == 1) ? 'نقدي' : 'علف') . ' </td>
                    <td>' . $items->paid . '</td>
                    <td>' . $farmer->name . '</td>
                    <td><input class="idSwitcher" type="radio" rel="' .
                     $items->id . '" /></td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $farmer = Farmer::read(
                        "SELECT * FROM farmers WHERE id = $item->farmer_id", 
                        PDO::FETCH_CLASS, 'Farmer');
                if ($item->payment == 1) {
                    $animalFood = '';
                } else {
                    $animalFood = AnimalFood::read(
                            "SELECT * FROM animalfood WHERE id = $item->animalfood_id", 
                            PDO::FETCH_CLASS, 'AnimalFood')->name;
                }
                $output .= '
                <tr class="gradeX">
                    <td>' . $item->created . ' </td>
                    <td>' . $animalFood . ' </td>
                    <td>' . (($item->payment == 1) ? 'نقدي' : 'علف') . ' </td>
                    <td>' . $item->paid . '</td>
                    <td>' . $farmer->name . '</td>
                    <td><input class="idSwitcher" name="farmer[]" type="radio" rel="' .
                         $item->id . '" /></td>
                </tr>';
            }
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }

    public static function renderAccounting ($sql)
    {
        $items = Farmer::read($sql, PDO::FETCH_CLASS, __CLASS__);
        $mainUrl = '/' . Helper::getView();
        
        $output = '<table class="mws-table">
                            <thead>
                                <tr>
                                    <th>التاريخ</th>
                                    <th>اللمدفوع</th>
                                    <th>مسلسل</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td>' . $items->created . '</td>
                    <td>' . $items->paid . '</td>
                    <td>1</td>
                </tr>';
        } else {
            $i = 1;
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td>' . $item->created . '</td>
                    <td>' . $item->paid . '</td>
                    <td>' . $i ++ . '</td>
                </tr>';
            }
        }
        $output .= '</tbody></table>';
        return $output;
    }
}