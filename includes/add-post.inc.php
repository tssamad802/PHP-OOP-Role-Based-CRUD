<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

// print_r($_POST);
// die();
    $user_id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $img = $_FILES['img'];

    $uploads_dir = './upload/';
    $img_name = $img['name'];
    $img_temp = $img['tmp_name'];

    $upload_img = $uploads_dir . $img_name;

    require_once 'config.session.inc.php';
    require_once 'dbh.inc.php';
    require_once 'model.php';
    require_once 'control.php';

    $db = new database();
    $conn = $db->connection();
    $controller = new controller($conn);

    $errors = [];

    // echo '<pre>';
    // print_r($img);
    // echo '</pre>';
    //exit;

    $slug = trim(preg_replace('/[\s-]+/', '-', preg_replace('/[^a-z0-9\s]/', '', strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $title)))), '-') . '-' . rand(100, 999);

    if ($controller->is_empty_inputs([$title, $content, $img, $category_id])) {
        $errors[] = "Please fill in all fields";
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header("Location: ./post-create");
        exit;
    }
    $insert_posts = [
        'title' => $title,
        'slug' => $slug,
        'content' => $content,
        'featured_image' => $upload_img,
        'user_id' => $user_id
    ];
 
    $result = $controller->insert_record('posts', $insert_posts);
    
    $result1 = move_uploaded_file($img_temp, $upload_img);
    foreach ($category_id as $key => $value) {
    $insert_category_posts = [
        'post_id' => $result,
        'category_id' => $value
    ];
    $result3 = $controller->insert_record('category_post', $insert_category_posts);
    
    }
    // echo "<pre>";
    // print_r($result3);
    // echo "</pre>";
    // exit;
    if ($result && $result1 && $result3) {
        header('Location: ./posts');
        exit;
    } else {
        header("Location: ./posts");
        exit;
    }
} else {
    header("Location: ./post-create");
    exit;
}
?>