<?php

class Driver extends DatabaseModel
{

    public $id;

    public $name;

    public $age;

    public $address;

    public $phone;

    public $licenseNumber;

    public $notes;

    public $status;

    protected $tableName = "drivers";

    protected $fields = array(
            'id',
            'name',
            'age',
            'address',
            'phone',
            'licenseNumber',
            'notes',
            'status'
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
                        <span class="mws-i-24 i-table-1">List of all drivers in the database</span>
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
                                    <th>Driver Code</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>License Number</th>
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
                    <td>' . $items->licenseNumber . ' </td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td><input class="idSwitcher" rel="' .
                         $item->id . '" type="radio" name="selectedRecord" /></td>
                    <td>MPRDFarmer-' . $item->id . '</td>
                    <td>' . $item->name . '</td>
                    <td>' . $item->age . ' </td>
                    <td>' . $items->licenseNumber . ' </td>
                </tr>';
            }
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }
}