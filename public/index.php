<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\CategoryController;
use App\Controllers\ArticleController;

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'category':
        (new CategoryController())->show();
        break;

    case 'article':
        (new ArticleController())->show();
        break;

    default:
        (new HomeController())->index();
}
