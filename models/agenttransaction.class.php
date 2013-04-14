<?php

class AgentTransaction extends DatabaseModel
{

    public $id;

    public $agent_id;

    public $quantity;

    public $lost;
    
    public $price;

    public $created;

    protected $tableName = "agenttransactions";

    protected $fields = array(
            'id',
            'agent_id',
            'quantity',
            'lost',
            'price',
            'created'
    );
    
    public static function getTransactionsOfThisMonth()
    {
        $startDate = date("Y") . '-' . date("m") . '-1';
        $endDate = date("Y") . '-' . date("m") . '-31';
        $sql = "SELECT SUM(quantity) as q FROM agenttransactions WHERE created >= '$startDate' AND created <= '$endDate'";
        $result = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        return $result ? $result->q : 0;
    }
    
    public static function getLostTransactionsOfThisMonth()
    {
        $startDate = date("Y") . '-' . date("m") . '-1';
        $endDate = date("Y") . '-' . date("m") . '-31';
        $sql = "SELECT SUM(lost) as q FROM agenttransactions WHERE created >= '$startDate' AND created <= '$endDate'";
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
                        <span class="mws-i-24 i-table-1">قائمة بالتعاملات مع العملاء</span>
                    </div>
                    <div class="mws-panel-body">
                        <div class="mws-panel-toolbar top clearfix">
                            <ul>
                                <li><a class="mws-ic-16 ic-add" href="' .
                 $mainUrl .
                 '/add">إضافة</a></li>
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
                                    <td></td>
                                    <th>العميل</th>
                                    <th>التاريخ</th>
                                    <th>الكمية</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td><input class="idSwitcher" type="radio" rel="' .
                     $items->id . '" /></td>
                    <td>' . Agent::read(
                            "SELECT name FROM agents WHERE id = $items->agent_id", 
                            PDO::FETCH_CLASS, 'Agent')->name . '</td>
                    <td>' . $items->created . '</td>        
                    <td class="center">' . $items->quantity . ' </td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td><input class="idSwitcher" rel="' .
                         $item->id . '" type="radio" name="selectedRecord" /></td>
                    <td>' . Agent::read(
                                "SELECT name FROM agents WHERE id = $item->agent_id", 
                                PDO::FETCH_CLASS, 'Agent')->name . '</td>
                    <td class="center">' . $item->created . ' </td>
                    <td class="center">' . $item->quantity . ' </td>
                </tr>';
            }
        }
        $output .= '</tbody></table></div></div>';
        return $output;
    }
}