<?php

class AnimalFood extends DatabaseModel
{

    public $id;
    
    public $name;
    
    public $quantity;
    
    public $sellprice;
    
    public $buyprice;

    protected $tableName = "animalfood";
    
    public static $table = 'animalfood';

    protected $fields = array(
            'id',
            'name',
            'quantity',
            'sellprice',
            'buyprice'
    );
    
    public static function getAllQuantities()
    {
        $sql = "SELECT SUM(quantity) as q FROM animalfood";
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
                        <span class="mws-i-24 i-table-1">قائمة بانواع العلف في قواعد البيانات</span>
                    </div>
                    <div class="mws-panel-body">
                        <div class="mws-panel-toolbar top clearfix">
                            <ul>
                                <li><a class="mws-ic-16 ic-add" href="' . $mainUrl . '/add">Add</a></li>
                                <li><a class="mws-ic-16 ic-edit" id="editLink" href="' . $mainUrl . '/edit">Edit</a></li>
                                <li><a class="mws-ic-16 ic-cross" id="deleteLink" href="' . $mainUrl . '/delete" onclick="' . $js . '">Delete</a></li>
                            </ul>
                        </div>
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <td></td>
                                    <th>سجل</th>
                                    <th>نوع العلف</th>    
                                    <th>الكمية بالمخزن</th>
                                    <th>سعر الشراء</th>
                                    <th>سعر البيع</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td><input class="idSwitcher" type="radio" rel="' .
                     $items->id . '" /></td>
                    <td>MPRDItem-' . $items->id . '</td>
                    <td>' . $items->name . '</td>
                    <td class="center">' . $items->quantity . ' </td>
                    <td class="center">' . $items->sellprice . ' </td>
                    <td class="center">' . $items->buyprice . ' </td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td><input class="idSwitcher" rel="' .
                         $item->id . '" type="radio" name="selectedRecord" /></td>
                    <td>MPRDItem-' . $item->id . '</td>
                    <td>' . $item->name . '</td>
                    <td class="center">' . $item->quantity . ' </td>
                    <td class="center">' . $item->sellprice . ' </td>
                    <td class="center">' . $item->buyprice . ' </td>
                </tr>';
            }
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }
}    