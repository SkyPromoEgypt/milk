<?php

class Supplier extends DatabaseModel
{

    public $id;

    public $name;

    public $address;

    public $phone;

    public $notes;

    public $status;
    
    public $tohim;

    protected $tableName = "suppliers";

    protected $fields = array(
            'id',
            'name',
            'address',
            'phone',
            'notes',
            'status',
            'tohim'
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
                        <span class="mws-i-24 i-table-1">قائمة بكل الموردين في قاعدة البيانات</span>
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
                                    <th>هاتف المورد</th>
                                    <th>عنوان المورد</th>
                                    <th>اسم المورد</th>
                                    <td width="2%"></td>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td class="center">' . $items->phone . ' </td>
                    <td class="center">' . $items->address . ' </td>
                    <td>' . $items->name . '</td>
                    <td><input class="idSwitcher" type="radio" rel="' .
                     $items->id . '" /></td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td class="center">' . $item->phone . ' </td>
                    <td class="center">' . $item->address . ' </td>
                    <td>' . $item->name . '</td>
                    <td><input class="idSwitcher" name="supplier" type="radio" rel="' .
                     $item->id . '" /></td>
                </tr>';
            }
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }
    
    public static function renderTransactionsList ($sql)
    {
        $items = Farmer::read($sql, PDO::FETCH_CLASS, 'AnimalFoodTransaction');
        $mainUrl = '/' . Helper::getView();
    
        $output = '<table class="mws-table">
                            <thead>
                                <tr>
                                    <th>التاريخ</th>
                                    <th>الكمية الموردة</th>
                                    <th>السعر</th><th>مسلسل</th>
                                </tr>
                            </thead>
                            <tbody>';
    
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td>' . $items->created . '</td>
                    <td>' . $items->quantity . '</td>
                    <td>' . $items->price . '</td>
                    <td>1</td>
                </tr>';
        } else {
            $i = 1;
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td>' . $item->price . '</td>
                    <td>' . $item->created . '</td>
                    <td>' . $item->quantity . '</td>
                    <td>' . $i ++ . '</td>
                </tr>';
            }
        }
        $output .= '</tbody></table>';
        return $output;
    }
}