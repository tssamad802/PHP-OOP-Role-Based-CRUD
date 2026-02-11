<?php
require_once './includes/config.session.inc.php';
require_once './includes/dbh.inc.php';
require_once './includes/auth.php';
require_once './includes/model.php';
require_once './includes/control.php';
$auth = new auth(['editor', 'admin']);
$db = new database();
$conn = $db->connection();
$controller = new controller($conn);
$posts_fetching = $controller->fetch_records('posts');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

  <h3 class="mb-3">Posts</h3>
   <a href="./dashboard"><button class="btn btn-secondary mb-3">Back</button></a>
  <a href="./post-create"><button class="btn btn-primary mb-3">+ New Post</button></a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Id</th>
        <th>Image</th>
        <th>Title</th>
        <th>Slug</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($posts_fetching as $row) { ?>
      <tr>
        <td><?php echo $row['id'] ?></td>
        <td><img src="<?php echo $row['featured_image'] ?>" width="50"></td>
        <td><?php echo $row['title'] ?></td>
        <td><?php echo $row['slug'] ?></td>
        <td>
          <a href="./edit-post?id=<?php echo $row['id']; ?>"><button class="btn btn-sm btn-warning">Edit</button></a>
          <?php if ($auth->can_access(['admin'])): ?>
            <a href="./delete-post-script?id=<?php echo $row['id']; ?>"><button class="btn btn-sm btn-danger">Delete</button></a>
          <?php endif; ?>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

</body>

</html>