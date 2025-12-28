<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Article;
use App\Helpers\View;

class HomeController
{
    public function index(): void
    {
        $smarty = View::make();

        $categories = Category::getAll();
        $result = [];

        foreach ($categories as $category) {
            $articles = Article::getLatest($category['id'], 3);

            if (empty($articles)) {
                continue;
            }

            $result[] = ['category' => $category,
                'articles' => $articles,
                'img' => random_int(1,3)
            ];
        }

        $smarty->assign('categories', $result);
        $smarty->display('home.tpl');
    }
}
