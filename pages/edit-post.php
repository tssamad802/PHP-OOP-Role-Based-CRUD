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
$auth = new auth(['editor', 'admin']);
$id = $_GET['id'];
$data = $controller->get_record_by_id('posts', $id);
$view = new view();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">

  <div class="container">
    <h2 class="mb-4">Edit Post</h2>

    <form action="./edit-post-script" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
      <input type="hidden" name="old_image" value="<?php echo $data['featured_image']; ?>">
      <div class="mb-3">
        <label for="postTitle" class="form-label">Post Title</label>
        <input type="text" class="form-control" id="postTitle" value="<?php echo $data['title']; ?>" name="title">
      </div>

      <div class="mb-3">
        <label for="postContent" class="form-label">Content</label>
        <textarea class="form-control" id="postContent" rows="6"
          name="content"><?php echo $data['content']; ?></textarea>
      </div>

      <div class="mb-3">
        <label for="postContent" class="form-label">Slug</label>
        <input type="text" class="form-control" id="postTitle" value="<?php echo $data['slug']; ?>" name="slug">
      </div>
      <div class="mb-3">
        <input type="file" class="form-control" name="img"><br>
        <?php if (!empty($data['featured_image'])): ?>
          <img src="<?php echo $data['featured_image'] ?>" width="50">
        <?php endif; ?>
      </div>
      <div class="d-flex justify-content-between">
        <a href="./posts" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-success">Update Post</button>
      </div>
      <?php
      $view->display_errors();
      ?>
    </form>
  </div>

</body>

</html>