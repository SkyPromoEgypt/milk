<?php

class AccountingSupplier extends DatabaseModel
{

    public $id;

    public $supplier_id;

    public $paid;

    public $created;

    protected $tableName = "accountingsupplier";

    protected $fields = array(
            'id',
            'supplier_id',
            'paid',
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
                        <span class="mws-i-24 i-table-1">قائمة بمدفوعاتنا للموردين</span>
                    </div>
                    <div class="mws-panel-body">
                        <div class="mws-panel-toolbar top clearfix">
                            <ul>
                                <li><a class="mws-ic-16 ic-add" href="' .
                 $mainUrl .
                 '/add">اضافة</a></li>
                                <li><a class="mws-ic-16 ic-edit" id="editLink" href="' .
                 $mainUrl .
                 '/edit">تعديل</a></li>
                                <li><a class="mws-ic-16 ic-cross" id="deleteLink" href="' .
                 $mainUrl . '/delete" onclick="' . $js . '">حذف</a></li>
                            </ul>
                        </div>
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th>تاريخ الدفع</th>
                                    <th>المبلغ المدفوع</th>
                                    <th>اسم المورد</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $supplier = Supplier::read("SELECT * FROM suppliers WHERE id = $items->supplier_id", 
                    PDO::FETCH_CLASS, 'Supplier');
            $output .= '<tr class="gradeX">
                    <td class="center">' .
                     $items->created . ' </td>
                    <td>' . $items->paid . '</td>
                    <td>' . $supplier->name . '</td>
                    <td><input class="idSwitcher" type="radio" rel="' .
                     $items->id . '" /></td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $supplier = Supplier::read("SELECT * FROM suppliers WHERE id = $item->supplier_id",
                        PDO::FETCH_CLASS, 'Agent');
                $output .= '
                <tr class="gradeX">
                    <td class="center">' .
                         $item->created . ' </td>
                    <td>' . $item->paid . '</td>
                    <td>' . $supplier->name . '</td>
                    <td><input class="idSwitcher" rel="' . $item->id . '" type="radio" name="selectedRecord" /></td>
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