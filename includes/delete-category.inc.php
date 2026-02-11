<?php

require_once 'config.session.inc.php';
require_once 'dbh.inc.php';
require_once 'model.php';
require_once 'control.php';

$db = new database();
$conn = $db->connection();
$controller = new controller($conn);
$id = $_GET['id'];
$test = $controller->delete_by_id('categories', $id);
$text2 = $controller->delete_category_by_id($id);
// echo '<pre>';
// print_r($test);
// echo '<pre>';
// exit;
header("Location: ./categories");
exit;
?>