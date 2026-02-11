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
$category_fetching = $controller->fetch_records('categories');
$auth = new auth(['editor', 'admin']);
$view = new view();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <form action="./add-post-script" method="post" enctype="multipart/form-data">
        <h3>Create Post</h3>
        <input type="hidden" name="id" value="<?php echo $auth->get_id(); ?>">
        <input class="form-control mb-3" placeholder="Title" name="title">
        <textarea class="form-control mb-3" rows="5" placeholder="Content" name="content"></textarea>

        <input type="file" class="form-control mb-3" name="img">
        <label for="exampleFormControlInput1" class="form-label">choose a category</label>
        <select class="form-select" aria-label="Default select example" name="category_id[]" multiple>
            <?php
            foreach ($category_fetching as $row) { ?>
            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
            <?php } ?> 
        </select><br>
        <button class="btn btn-success">Save</button>
        <?php
        $view->display_errors();
        ?>
    </form>

</body>

</html>