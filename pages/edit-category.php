<?php
require_once './includes/config.session.inc.php';
require_once './includes/auth.php';
require_once './includes/dbh.inc.php';
require_once './includes/model.php';
require_once './includes/control.php';
require_once './includes/view.php';
$db = new database();
$conn = $db->connection();
$controller = new controller($conn);
$auth = new auth(['admin']);
$id = $_GET['id'];
$data = $controller->get_record_by_id('categories', $id);
$view = new view();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4 bg-light">

    <div class="container">
        <h3 class="mb-4">Edit Category</h3>

        <form action="./edit-category-script" method="POST">
            <input type="hidden" value="<?php echo $data['id']; ?>" name="id">
            <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="categoryName" placeholder="Enter category name"
                    name="category" value="<?php echo $data['name']; ?>">
            </div>
            <button type="submit" class="btn btn-success">Save Category</button>
        </form>
        <br>
        <a href="./categories"><button class="btn btn-secondary">Back</button></a>
            <?php
    $view->display_errors();
    ?>
    </div>
</body>

</html>