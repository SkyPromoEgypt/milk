<?php

class Agent extends DatabaseModel
{

    public $id;

    public $name;

    public $address;

    public $phone;

    public $notes;

    public $status;
    
    public $onhim;

    protected $tableName = "agents";

    protected $fields = array(
            'id',
            'name',
            'address',
            'phone',
            'notes',
            'status',
            'onhim'
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
                        <span class="mws-i-24 i-table-1">قائمة بكل العملاء في قاعدة البيانات</span>
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
                                    <th>كود العميل</th>
                                    <th>اسم العميل</th>
                                    <th>عنوان العميل</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td><input class="idSwitcher" type="radio" rel="' .
                     $items->id . '" /></td>
                    <td>MPRDAgent-' . $items->id . '</td>
                    <td>' . $items->name . '</td>
                    <td class="center">' . $items->address . ' </td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td><input class="idSwitcher" rel="' .
                         $item->id . '" type="radio" name="selectedRecord" /></td>
                    <td>MPRDAgent-' . $item->id . '</td>
                    <td>' . $item->name . '</td>
                    <td class="center">' . $item->address . ' </td>
                </tr>';
            }
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }
    
    public static function renderTransactionsList ($sql)
    {
        $items = Farmer::read($sql, PDO::FETCH_CLASS, 'AgentTransaction');
        $mainUrl = '/' . Helper::getView();
    
        $output = '<table class="mws-table">
                            <thead>
                                <tr><th>مسلسل</th>
                                    <th>التاريخ</th>
                                    <th>الكمية الموردة</th>
                                    <th>السعر</th>
                                </tr>
                            </thead>
                            <tbody>';
    
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td>1</td>
                    <td>' . $items->created . '</td>
                    <td>' . $items->quantity . '</td>
                    <td>' . $items->price . '</td>
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