<?php
require_once './includes/config.session.inc.php';
require_once './includes/auth.php';
require_once './includes/dbh.inc.php';
require_once './includes/model.php';
require_once './includes/control.php';

$db = new database();
$conn = $db->connection();
$controller = new controller($conn);
$auth = new auth(['admin']);


$slug = basename($_SERVER['REQUEST_URI']); 
$conditions = ['categories.slug' => $slug]; 
$join = "INNER JOIN category_post cp ON categories.id = cp.category_id
         INNER JOIN posts p ON cp.post_id = p.id";
$category = $controller->fetch_records('categories', $conditions, $join);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category: <?php echo $slug; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h2 class="mb-4 text-center">Category: <?php echo $slug; ?></h2>
        <div class="row g-4">
            <?php if(!empty($category)) {
                foreach ($category as $row) { ?>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img src=".<?php echo $row['featured_image'] ?>" class="card-img-top" alt="<?php echo $row['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name'] ?></h5>
                            <p class="card-text">Slug: <strong><?php echo $row['slug'] ?></strong></p>
                        </div>
                    </div>
                </div>
            <?php } } else { ?>
                <p class="text-center">No posts found for this category.</p>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
