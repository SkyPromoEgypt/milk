<?php

class AnimalFoodTransaction extends DatabaseModel
{

    public $id;
    
    public $cat_id;

    public $supplier_id;
    
    public $created;

    public $quantity;
    
    public $lost;
    
    public $price;

    protected $tableName = "animalfoodtransactions";
    
    public static $table = 'animalfoodtransactions';

    protected $fields = array(
            'id',
            'cat_id',
            'supplier_id',
            'created',
            'quantity',
            'lost',
            'price'
    );
    
    public static function getAllQuantitiesOfThisMonth()
    {
        $startDate = date("Y") . '-' . date("m") . '-1';
        $endDate = date("Y") . '-' . date("m") . '-31';
        $sql = "SELECT SUM(quantity) as q FROM animalfoodtransactions WHERE created >= '$startDate' AND created <= '$endDate'";
        $result = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        return $result ? $result->q : 0;
    }
    
    public static function getLostOfThisMonth()
    {
        $startDate = date("Y") . '-' . date("m") . '-1';
        $endDate = date("Y") . '-' . date("m") . '-31';
        $sql = "SELECT SUM(lost) as q FROM animalfoodtransactions WHERE created >= '$startDate' AND created <= '$endDate'";
        $result = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        return $result ? $result->q : 0;
    }

    public static function renderForControl ($sql, $className)
    {
        $items = self::read($sql, PDO::FETCH_CLASS, $className);
        
        $mainUrl = '/' . Helper::getView();
        
        $message = 'Do you really want to delete this item ?';
        
        $js = 'if(confirm(\'' . $message .
                 '\')) { return true; } else { return false; }';
        
        $output = '<div class="mws-panel grid_8">
                    <div class="mws-panel-header">
                        <span class="mws-i-24 i-table-1">قائمة بتورديات العلف في قاعدة البيانات</span>
                    </div>
                    <div class="mws-panel-body">
                        <div class="mws-panel-toolbar top clearfix">
                            <ul>
                                <li><a class="mws-ic-16 ic-add" href="' . $mainUrl . '/add">اضافة</a></li>
                                <li><a class="mws-ic-16 ic-edit" id="editLink" href="' . $mainUrl . '/edit">تعديل</a></li>
                                <li><a class="mws-ic-16 ic-cross" id="deleteLink" href="' . $mainUrl . '/delete" onclick="' . $js . '">حذف</a></li>
                            </ul>
                        </div>
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <td></td>
                                    <th>سجل</th>
                                    <th>اسم المورد</th>
                                    <th>تاريخ التوريد</th>    
                                    <th>الكمية</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td><input class="idSwitcher" type="radio" rel="' .
                     $items->id . '" /></td>
                    <td>MPRDItem-' . $items->id . '</td>
                    <td>' . Supplier::read("SELECT * FROM suppliers WHERE id = $items->supplier_id", PDO::FETCH_CLASS, "Supplier")->name . '</td>
                    <td>' . $items->created . '</td>
                    <td class="center">' . $items->quantity . ' </td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td><input class="idSwitcher" rel="' .
                         $item->id . '" type="radio" name="selectedRecord" /></td>
                    <td>MPRDItem-' . $item->id . '</td>
                    <td>' . Supplier::read("SELECT * FROM suppliers WHERE id = $item->supplier_id", PDO::FETCH_CLASS, "Supplier")->name . '</td>
                    <td>' . $item->created . '</td>
                    <td class="center">' . $item->quantity . ' </td>
                </tr>';
            }
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }
}    