<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $edit_category_name = $_POST['category'];

    require_once 'config.session.inc.php';
    require_once 'dbh.inc.php';
    require_once 'model.php';
    require_once 'control.php';

    $db = new database();
    $conn = $db->connection();
    $controller = new controller($conn);

    $errors = [];

    if ($controller->is_empty_inputs([$edit_category_name])) {
        $errors[] = "Please fill in all fields";
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header("Location: ./edit-category?id=$id");
        exit;
    }

    $result = $controller->update('categories', $id, ['name' => $edit_category_name]);
    if ($result) {
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        header('Location: ./categories');
        exit;
    }
} else {
    header("Location: ./edit-category?id=$id");
    exit;
}
?>