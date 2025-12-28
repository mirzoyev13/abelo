<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Database\DB;

$db = DB::getInstance();
$db->exec("SET FOREIGN_KEY_CHECKS = 0");
$db->exec("TRUNCATE TABLE article_category");
$db->exec("TRUNCATE TABLE articles");
$db->exec("TRUNCATE TABLE categories");
$db->exec("SET FOREIGN_KEY_CHECKS = 1");

$categories = [
    ['PHP', 'Laravel / Symphony / Codegniter'],
    ['JavaScript', 'React / Vue / TypeScript'],
    ['Style', 'Bootstrap / Tailwind / Smarty'],
];

$categoryIds = [];
$stmt = $db->prepare(" INSERT INTO categories (name, description) VALUES (:name, :description)");

foreach ($categories as $category) {
    $stmt->execute([ 'name' => $category[0],
        'description' => $category[1],
    ]);
    $categoryIds[] = $db->lastInsertId();
}

$stmtArticle = $db->prepare(" INSERT INTO articles (title, description, content, views, published_at) VALUES (:title, :description, :content, :views, :published_at)");

$stmtPivot = $db->prepare(" INSERT INTO article_category (article_id, category_id) VALUES (:article_id, :category_id)");

for ($i = 1; $i <= 15; $i++) {
    $stmtArticle->execute([ 'title' => "Тестовая статья {$i}",
        'description' => "Описание статьи {$i}",
        'content' => "Текст статьи {$i}. Lorem ipsum dolor",
        'views' => rand(0, 221),
        'published_at' => date('Y-m-d H:i:s', strtotime("-{$i} days")),
    ]);

    $articleId = $db->lastInsertId();
    $randomCategories = array_rand($categoryIds, rand(1, 2));

    if (!is_array($randomCategories)) $randomCategories = [$randomCategories];

    foreach ($randomCategories as $index) {
        $stmtPivot->execute(['article_id' => $articleId,
            'category_id' => $categoryIds[$index],
        ]);
    }
}