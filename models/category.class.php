<?php

class Category extends DatabaseModel
{

    public $id;

    public $atitle;

    public $etitle;

    public $acontent;

    public $econtent;

    protected $tableName = "categories";

    protected $fields = array(
            'id',
            'atitle',
            'etitle',
            'acontent',
            'econtent'
    );

    public static function renderForControl ($perPage = 5)
    {
        $page = ! empty($_GET['page']) ? (int) $_GET['page'] : 1;
        $totalCount = count(self::getAll('categories'));
        $pagination = new Pagination($page, $perPage, $totalCount);
        $sql = "SELECT * FROM categories ";
        $sql .= "ORDER BY id ASC ";
        $sql .= "LIMIT {$perPage} ";
        $sql .= "OFFSET {$pagination->offset()}";
        
        $items = self::read($sql, PDO::FETCH_CLASS, __CLASS__);
        
        $mainUrl = '/_administrator/categories';
        
        $output = '<table class="tableControl">';
        $output .= '<tr><th width="4%">#</th><th width="94%">Subject</th><th width="2%" colspan="2">Control</th></tr>';
        $i = 1;
        $message = 'Do you really want to delete this item ?';
        $js = 'if(confirm(\'' . $message .
        '\')) { return true; } else { return false; }';
        
        if(!is_array($items)) {
            $output .= '
    		<tr>
                <td width="4%">' . $i . '</td>
                <td width="94%"> ' . $items->etitle . '</td>
                <td width="1%">
                    <a href="' . $mainUrl . '/edit/' . $items->id . '">
                        <img src="_images/b_edit.png" />
                    </a>
                </td>
    			<td width="1%">
                    <a href="' . $mainUrl . '/delete/' . $items->id . '" onclick="' . $js . '">
                        <img src="_images/b_drop.png" />
                    </a>
                </td>
            </tr>';
        } else {
            foreach ($items as $item) {
                $output .= '
    			<tr>
                    <td width="4%">' . $i . '</td>
                    <td width="94%"> ' . $item->etitle . '</td>
                    <td width="1%">
                        <a href="' . $mainUrl . '/edit/' . $item->id . '">
                            <img src="_images/b_edit.png" />
                        </a>
                    </td>
        			<td width="1%">
                        <a href="' . $mainUrl . '/delete/' . $item->id . '" onclick="' . $js . '">
                            <img src="_images/b_drop.png" />
                        </a>
                    </td>
                </tr>';
                $i++;
            }    
        }
        $output .= '</table>';
        $output .= '<a class="itemadd" href="' . $mainUrl . '/add">+    Add New Item</a>';
        $output .= $pagination->paginationNav($mainUrl, true);
        return $output;
    }
}