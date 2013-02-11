<?php

class AnimalFoodTransaction extends DatabaseModel
{

    public $id;
    
    public $cat_id;

    public $name;
    
    public $created;

    public $quantity;

    protected $tableName = "animalfoodtransactions";
    
    public static $table = 'animalfoodtransactions';

    protected $fields = array(
            'id',
            'cat_id',
            'name',
            'created',
            'quantity'
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
                        <span class="mws-i-24 i-table-1">List of all animal food in the database</span>
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
                                    <th>Record</th>
                                    <th>Supplier\'s Name</th>
                                    <th>Date / Time</th>    
                                    <th>quantity</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td><input class="idSwitcher" type="radio" rel="' .
                     $items->id . '" /></td>
                    <td>MPRDItem-' . $items->id . '</td>
                    <td>' . $items->name . '</td>
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
                    <td>' . $item->name . '</td>
                    <td>' . $item->created . '</td>
                    <td class="center">' . $item->quantity . ' </td>
                </tr>';
            }
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }
}    