<?php
require_once './includes/config.session.inc.php';
require_once './includes/auth.php';

$auth = new auth(['viewer', 'editor', 'admin']);
?>

<!DOCTYPE html>
<html>
<head>
<title>Post</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-5">

<h1><?php echo $post['title']; ?></h1>
<p class="text-muted"><?php echo $post['published_at']; ?></p>
<img src=".<?php echo $post['featured_image']; ?>" class="img-fluid mb-4">
<p><?php echo $post['content']; ?></p>

</body>
</html>
