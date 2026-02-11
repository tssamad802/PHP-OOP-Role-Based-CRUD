<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $new_image = $_FILES['img'];
    $old_image = $_POST['old_image'];
    $file_name = basename($old_image);

    // echo "<pre>";
    // print_r($old_image);
    // echo "</pre>";
    // exit;
    $uploads_dir = './upload/';
    $new_img_name = $new_image['name'];
    $new_img_temp = $new_image['tmp_name'];

    $upload_img = $uploads_dir . $new_img_name;

    require_once 'config.session.inc.php';
    require_once 'dbh.inc.php';
    require_once 'model.php';
    require_once 'control.php';

    $db = new database();
    $conn = $db->connection();
    $controller = new controller($conn);

    $errors = [];

    if ($controller->is_empty_inputs([$title, $content, $slug, $new_image])) {
        $errors[] = "Please fill in all fields";
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header("Location: ./edit-post?id=$id");
        exit;
    }

    $updateData = [
        'title' => $title,
        'slug' => $slug,
        'content' => $content
    ];

    if (isset($new_image['name']) && $new_image['name'] != '') {
        $new_img_name = $new_image['name'];
        $new_img_temp = $new_image['tmp_name'];

        move_uploaded_file($new_img_temp, $uploads_dir . $new_img_name);

        if (!empty($old_image) && file_exists($uploads_dir . $file_name)) {
            unlink($uploads_dir . $file_name);
        }
        $updateData['featured_image'] = $upload_img;
    }
    $result = $controller->update('posts', $id, $updateData);
    if ($result) {
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        header('Location: ./posts');
        exit;
    } else {
        echo "Error updating post!";
    }
} else {
    header('Location: ./posts');
    exit;
}
?>