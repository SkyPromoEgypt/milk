<?php
function xmltomysql ($file)
{
    $dom = DOMDocument::load($file);
    $rows = $dom->getElementsByTagName('Row');
    $filteredArray = array();
    foreach ($rows as $row) {
        if (! empty($row)) {
            $rowFields = array();
            $cells = $row->getElementsByTagName('Cell');
            foreach ($cells as $cell) {
                $rowFields[] = $cell->nodeValue;
            }
            if (! empty($rowFields)) {
                if(!empty($rowFields[0])) {
                    $farmer = new Farmer();
                    $farmer->name = $rowFields[0];
                    $farmer->status = 1;
                    if($farmer->save()) {
                        echo '<p>' . $farmer->name . ' Farmer Saved</p>';
                    }
                }
            }
        }
    }
    echo '<pre>';
    print_r($filteredArray);
    echo '</pre>';
}

if (isset($_POST['submit'])) {
    $file = $_FILES['file']['tmp_name'];
    xmltomysql($file);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>XMLTOMYSQL</title>
</head>
<body>
	<form action="" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td><label for="logo">Excel file</label></td>
				<td><input name="file" id="file" type="file" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input name="submit" id="submit" type="submit" value="Submit" /></td>
			</tr>
		</table>
	</form>
</body>
</html>