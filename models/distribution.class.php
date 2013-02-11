<?php

class Distribution extends DatabaseModel
{
    public $id;

    public $theid;

    public $quantity;

    public $thetime;

    public $created;

    protected $tableName = "distribution";

    protected $fields = array(
            'id',
            'theid',
            'quantity',
            'thetime',
            'created'
    );

    public static function renderForControl ($sql, $className)
    {
        $items = Farmer::read($sql, PDO::FETCH_CLASS, "Farmer");
        
        $mainUrl = '/' . Helper::getView();
        
        $message = 'Do you really want to delete this item ?';
        
        $js = 'if(confirm(\'' . $message .
                 '\')) { return true; } else { return false; }';
        
        $output = '<form method="post" action=""><table class="mws-table">
                            <thead>
                                <tr>
                                    <th>اسم المزارع</th>
                                    <th>كمية الصبح</th>
                                    <th>سعر خاص</th>
                                    <th>كمية المساء</th>
                                    <th>سعر خاص</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        if (! is_array($items)) {
            $output .= '<tr class="gradeX">
                    <td>' . $items->name . '</td>
                    <td><input type="text" name="mquantity"></td>
                    <td><input type="text" name="mprice"></td>
                    <td><input type="text" name="equantity"></td>
                    <td><input type="text" name="eprice"></td>
                </tr>';
        } else {
            foreach ($items as $item) {
                $output .= '
                <tr class="gradeX">
                    <td>' . $item->name . '</td>
                    <td><input type="text" name="mquantity"></td>
                    <td><input type="text" name="mprice"></td>
                    <td><input type="text" name="equantity"></td>
                    <td><input type="text" name="eprice"></td>
                </tr>';
            }
        }
        $output .= '</tbody></table><input type="submit" name="save" value="حفظ" style="float:right;display:block;margin:15px 0 0 0;"></form>';
        return $output;
    }
}