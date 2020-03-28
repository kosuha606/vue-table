<?php


$dataStr = file_get_contents('data.json');

$data = json_decode($dataStr, true);




echo json_encode(['items' => $data]);