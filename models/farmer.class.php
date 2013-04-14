<?php

class Farmer extends DatabaseModel
{

    public $id;

    public $name;

    public $specialprice;

    public $notes;

    public $status;
    
    public $onhim;
    
    public $tohim;

    protected $tableName = "farmers";

    protected $fields = array(
            'id',
            'name',
            'specialprice',
            'notes',
            'status',
            'onhim',
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
                        <span class="mws-i-24 i-table-1">قائمة بكل المزارعين في البرنامج</span>
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
                                    <th>كود المزارع</th>
                                    <th>اسم المزارع</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td><input class="idSwitcher" type="radio" rel="' .
                     $items->id . '" /></td>
                    <td>MPRDFarmer-' . $items->id . '</td>
                    <td>' . $items->name . '</td>
                    <td>' . $items->age . ' </td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td><input class="idSwitcher" rel="' .
                         $item->id . '" type="radio" name="selectedRecord" /></td>
                    <td>MPRDFarmer-' . $item->id . '</td>
                    <td>' . $item->name . '</td>
                </tr>';
            }
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }
}