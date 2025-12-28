<?php

namespace App\Controllers;

use App\Models\Article;
use App\Helpers\View;

class ArticleController
{
    public function show(): void
    {
        $articleId = ($_GET['id'] ?? 0);

        if ($articleId <= 0) {
            http_response_code(404);
            return;
        }

        $article = Article::find($articleId);

        Article::increaseViewsNumber($articleId);

        $similarArticles = Article::similarBlogs($articleId, 3);
        if (!empty($similarArticles)) {
            $smarty = View::make();
            $smarty->assign(['article' => $article,
                'similarArticles' => $similarArticles,
            ]);
        }

        $smarty->display('article.tpl');
    }
}
