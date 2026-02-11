<?php
require_once './includes/config.session.inc.php';
require_once './includes/dbh.inc.php';
require_once './includes/auth.php';
require_once './includes/model.php';
require_once './includes/control.php';
$auth = new auth(['admin']);
$db = new database();
$conn = $db->connection();
$controller = new controller($conn);
$join = "LEFT JOIN category_post cp ON c.id = cp.category_id
LEFT JOIN posts p ON cp.post_id = p.id
LEFT JOIN users u ON p.user_id = u.id";
$posts_with_categories = $controller->fetch_records('categories');
// print_r($posts_with_categories);
// exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Categories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4 bg-light">

  <div class="container">
    <h3 class="mb-4">Categories</h3>

    <div class="row mb-4">
      <div class="col-md-2">
        <a href="./dashboard"><button class="btn btn-secondary w-100">Back</button></a>
      </div>
      <div class="col-md-2">
        <a href="./add-category"><button class="btn btn-primary w-100">Add Category</button></a>
      </div>
    </div>

    <table class="table table-bordered table-hover bg-white">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Slug</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($posts_with_categories as $row) { ?>
          <tr>
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['slug'] ?></td>
            <td><?php echo $row['created_at'] ?></td>
            <td>
              <a href="./category/<?php echo $row['slug'] ?>"><button class="btn btn-sm btn-info">Show</button></a>
              <a href="./edit-category?id=<?php echo $row['id'] ?>"><button
                  class="btn btn-sm btn-warning">Edit</button></a>
              <a href="./delete-category?id=<?php echo $row['id'] ?>"><button
                  class="btn btn-sm btn-danger">Delete</button></a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

</body>

</html>