<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Article;
use App\Services\Paginator;
use App\Helpers\View;

class CategoryController
{
    public function show(): void
    {
        $categoryId = ($_GET['id'] ?? 0);
        $sort = $_GET['sort'] ?? 'date';
        $page = (int)($_GET['p'] ?? 1);

        if ($categoryId <= 0) {
            http_response_code(404);
            return;
        }

        $category = Category::find($categoryId);

        if ($category) {

            $totalArticles = Article::counter($categoryId);
            $paginator = new Paginator($totalArticles, $page, 5);

            $articles = Article::byCategory($categoryId, $sort, $paginator->perPage, $paginator->offset());

            $smarty = View::make();

            $smarty->assign(['category' => $category,
                'articles' => $articles,
                'paginator' => $paginator,
                'sort' => $sort,
            ]);

            $smarty->display('category.tpl');
        }

    }
}
