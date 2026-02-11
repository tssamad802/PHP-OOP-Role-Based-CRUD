<?php
require_once './includes/config.session.inc.php';
require_once './includes/dbh.inc.php';
require_once './includes/auth.php';
require_once './includes/model.php';
require_once './includes/control.php';
$auth = new auth(['editor', 'admin', 'viewer']);
$db = new database();
$conn = $db->connection();
$controller = new controller($conn);
$posts_fetching = $controller->fetch_records('posts');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['search'])) {
    $search = $_POST['search'];
    $posts_fetching = $controller->search('posts', 'title', $search);
} else {
    $posts_fetching = $controller->fetch_records('posts');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Posts</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .card-title {
      font-weight: 600;
    }

    .card-text {
      color: #555;
    }

    .btn-manage:hover {
      transform: translateY(-2px);
      transition: 0.3s;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      transition: 0.3s;
    }
  </style>
</head>

<body>

  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">MyBlog</a>
      <div class="d-flex align-items-center ms-auto">
        <span class="me-3">Hello, <strong><?php echo $auth->show_name(); ?></strong></span>
        <a href="./logout" class="btn btn-outline-danger btn-sm">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container">

    <!-- Search Bar + Manage Posts Button -->
    <div class="row mb-4 align-items-center">
      <div class="col-md-6 mb-2 mb-md-0">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search posts..." aria-label="Search" name="search">
          <button class="btn btn-primary">Search</button>
        </form> 
      </div>
      <div class="col-md-6 text-md-end">
        <?php if ($auth->can_access(['editor', 'admin'])): ?>
          <a href="./posts" class="btn btn-success btn-manage">Manage Posts</a>
        <?php endif; ?>
        <?php if ($auth->can_access(['admin'])): ?>
          <a href="./categories" class="btn btn-success btn-manage">Manage Categories</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Posts Grid -->
    <!-- Posts Grid -->
    <div class="row g-4">
      <?php foreach ($posts_fetching as $row) { ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm border-0">

            <!-- Fixed Image -->
            <img src="<?php echo $row['featured_image']; ?>" class="card-img-top img-fluid object-fit-cover"
              style="height: 200px;" alt="Post Image">

            <div class="card-body d-flex flex-column">
              <h5 class="card-title text-truncate">
                <?php echo $row['title']; ?>
              </h5>

              <p class="card-text small text-muted mb-4 overflow-hidden" style="max-height: 60px;">
                <?php echo $row['content']; ?>
              </p>

              <a href="./post/<?php echo $row['slug'] ?>" class="btn btn-outline-primary mt-auto w-100">
                View Post
              </a>
            </div>

          </div>
        </div>
      <?php } ?>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>