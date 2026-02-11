<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $category_name = $_POST['category_name'];

    require_once 'config.session.inc.php';
    require_once 'dbh.inc.php';
    require_once 'model.php';
    require_once 'control.php';

    $db = new database();
    $conn = $db->connection();
    $controller = new controller($conn);

    $category_slug = $category_name . rand(99, 98);
    $errors = [];

    if ($controller->is_empty_inputs([$category_name])) {
        $errors[] = "Please fill in all fields";
    }
    if ($controller->check_record('categories', ["name" => $category_name])) {
        $errors[] = "Category already saved";
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header("Location: ./add-category");
        exit;
    }

    $result = $controller->insert_record('categories', ["name" => $category_name, 'slug' => $category_slug]);
    if ($result) {
        header("Location: ./categories");
        exit;
    } else {
        header("Location: ./categories");
        exit;
    }

} else {
    header("Location: ./category-create-script");
    exit;
}
?>