<?php
require_once './includes/config.session.inc.php';
require_once './includes/dbh.inc.php';
require_once './includes/auth.php';
require_once './includes/model.php';
require_once './includes/control.php';
require_once './includes/view.php';
$auth = new auth(['admin']);
$view = new view();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add/Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4 bg-light">

    <div class="container">
        <h3 class="mb-4">Add Category</h3>

        <form action="./category-create-script" method="POST">
            <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="categoryName" placeholder="Enter category name"
                    name="category_name">
            </div>
            <button type="submit" class="btn btn-success">Save Category</button>
        </form><br>
        <a href="./categories"><button class="btn btn-secondary">Back</button></a>
        <?php
        $view->display_errors();
        ?>
    </div>

</body>

</html>