<?php

use app\DB;

require_once __DIR__.'/vendor/autoload.php';

$limit = 0;
$offset = 0;

$_POST = json_decode(file_get_contents('php://input'), true);
$pagination = $_POST['pagination'] ?? ['page' => 1, 'itemsPerPage' => 10];

$limit = $pagination['itemsPerPage'];
$offset = ($pagination['page']-1)*$pagination['itemsPerPage'];

$sortField = 'id';
$sortDireciton = 'asc';

if (isset($_POST['sort'])) {
    $sortField = $_POST['sort']['field'];
    $sortDireciton = $_POST['sort']['direction'];
}

$whereItems = [];

if (isset($_POST['filters'])) {
    foreach ($_POST['filters'] as $key => $value) {
        switch ($key) {
            case 'name':
                $whereItems[] = "name LIKE '%$value%'";
                break;
        }
    }
}

$where = '';
if ($whereItems) {
    $where = 'WHERE '.join(' AND ', $whereItems);
}

/** @var PDOStatement $cnt */
$cnt = DB::query("SELECT COUNT(id) as cnt from products $where")->fetch();


$data = [];
$sql = "SELECT * FROM products $where ORDER BY $sortField $sortDireciton LIMIT $offset, $limit";
foreach (DB::query($sql) as $item) {
    $data[] = $item;
}





echo json_encode([
    'total' => (int)$cnt['cnt'],
    'items' => $data
]);