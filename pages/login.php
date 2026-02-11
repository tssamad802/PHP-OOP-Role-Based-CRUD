<?php
require_once './includes/config.session.inc.php';
require_once './includes/view.php';
$view = new view();
if (isset($_SESSION['name'])) {
    header("Location: ./dashboard"); 
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

  <div class="card p-4" style="width:350px">
    <form action="./login-script" method="post">
      <h4 class="mb-3 text-center">Login</h4>
      <input class="form-control mb-3" placeholder="Email" name="email">
      <input type="password" class="form-control mb-3" placeholder="Password" name="pwd">
      <button class="btn btn-dark w-100">Login</button>
      <?php
      $view->display_errors();
      ?>
    </form>
  </div>

</body>

</html>