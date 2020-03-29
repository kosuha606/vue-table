<?php

use app\DB;

require_once __DIR__.'/vendor/autoload.php';

$limit = 0;
$offset = 0;

$_POST = json_decode(file_get_contents('php://input'), true);
$pagination = $_POST['pagination'] ?? ['page' => 1, 'itemsPerPage' => 10];

$limit = $pagination['itemsPerPage'];
$offset = ($pagination['page']-1)*$pagination['itemsPerPage'];

/** @var PDOStatement $cnt */
$cnt = DB::query("SELECT COUNT(id) as cnt from products")->fetch();

$data = [];
foreach (DB::query("SELECT * FROM products LIMIT $offset, $limit") as $item) {
    $data[] = $item;
}





echo json_encode([
    'total' => (int)$cnt['cnt'],
    'items' => $data
]);