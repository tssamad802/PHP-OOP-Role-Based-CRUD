<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    require_once 'config.session.inc.php';
    require_once 'dbh.inc.php';
    require_once 'model.php';
    require_once 'control.php';

    $db = new database();
    $conn = $db->connection();
    $controller = new controller($conn);

    $errors = [];

    if ($controller->is_empty_inputs([$email, $pwd])) {
        $errors[] = "Please fill in all fields";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is invalid";
    }

    if ($errors) {
        $_SESSION['errors'] = $errors;
        header("Location: ./login");
        exit;
    }
    $conditions = [
        'email' => $email,
        'pwd' => $pwd
    ];
    $result = $controller->check_record('users', $conditions);
    if ($result) {
        $role = $result[0]['role'];
        $_SESSION['id'] = $result[0]['id'];
        $_SESSION['name'] = $result[0]['name'];
        $_SESSION[$role] = $result[0]['role'];
        // echo "<pre>";
        // print_r($result[0]['role']);
        // echo "</pre>";
        // exit;
        header("Location: ./dashboard");
        exit;
    } else {
        header("Location: ./login");
        exit;
    }
} else {
    header("Location: ./login");
    exit;
}
?>