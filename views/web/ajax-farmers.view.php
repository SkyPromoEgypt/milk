<?php

$farmers = Farmer::read("SELECT id, name FROM farmers WHERE name LIKE '%" . $_POST['name'] . "%'", PDO::FETCH_ASSOC);
echo json_encode($farmers, JSON_UNESCAPED_UNICODE);
header("Content-type: text/json");