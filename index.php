<?php
require_once './includes/config.session.inc.php';
require_once './includes/dbh.inc.php';
require_once './includes/auth.php';
require_once './includes/model.php';
require_once './includes/control.php';

$db = new database();
$conn = $db->connection();
$controller = new controller($conn);

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = str_replace('/task2', '', $request);
$request = rtrim($request, '/');

if ($request == '') {
    $request = '/';
}
if (preg_match('#^/post/([\w-]+)$#', $request, $matches)) {

    $slug = $matches[1];
    $posts_fetching = $controller->fetch_records('posts', ['slug' => $slug]);

    if (!empty($posts_fetching)) {
        $post = $posts_fetching[0];
        require __DIR__ . '/pages/post-slug.php';
    } else {
        http_response_code(404);
        require __DIR__ . '/pages/404.php';
    }

    exit;
}

if (preg_match('#^/category/([\w-]+)$#', $request, $matches)) {

    $slug = $matches[1];
    $category_fetching = $controller->fetch_records('categories', ['slug' => $slug]);

    if (!empty($category_fetching)) {
        $category = $category_fetching[0];
        require __DIR__ . '/pages/category-slug.php';
    } else {
        http_response_code(404);
        require __DIR__ . '/pages/404.php';
    }

    exit;
}
switch ($request) {

    case '/':
    case '/login':
        require __DIR__ . '/pages/login.php';
        break;

    case '/dashboard':
        require __DIR__ . '/pages/dashboard.php';
        break;

    case '/categories':
        require __DIR__ . '/pages/categories.php';
        break;

    case '/posts':
        require __DIR__ . '/pages/posts.php';
        break;

    case '/post-create':
        require __DIR__ . '/pages/post-create.php';
        break;

    case '/edit-post':
        require __DIR__ . '/pages/edit-post.php';
        break;

    case '/add-category':
        require __DIR__ . '/pages/add-category.php';
        break;

    case '/edit-category':
        require __DIR__ . '/pages/edit-category.php';
        break;

    case '/login-script':
        require __DIR__ . '/includes/login.inc.php';
        break;

    case '/logout':
        require __DIR__ . '/includes/logout.inc.php';
        break;

    case '/add-post-script':
        require __DIR__ . '/includes/add-post.inc.php';
        break;

    case '/edit-post-script':
        require __DIR__ . '/includes/edit-post.inc.php';
        break;

    case '/delete-post-script':
        require __DIR__ . '/includes/post-delete.inc.php';
        break;

    case '/category-create-script':
        require __DIR__ . '/includes/category-create.inc.php';
        break;
  case '/edit-category-script':
        require __DIR__ . '/includes/edit-category.inc.php';
        break;
          case '/delete-category':
        require __DIR__ . '/includes/delete-category.inc.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/pages/404.php';
        break;
}
