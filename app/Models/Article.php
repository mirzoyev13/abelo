<?php

namespace App\Models;

use App\Database\DB;
use PDO;

class Article
{
    public static function getLatest(int $categoryId, int $limit = 3): array
    {
        $db = DB::getInstance();

        $sql = " SELECT a.*
            FROM articles a
            JOIN article_category ac ON ac.article_id = a.id
            WHERE ac.category_id = :category_id
            ORDER BY a.published_at DESC
            LIMIT :limit
        ";
        // test

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function byCategory(int $categoryId, string $sort, int $limit, int $offset): array
    {
        $db = DB::getInstance();

        $orderBy = match ($sort) {
            'views' => 'a.views DESC',
            default => 'a.published_at DESC'
        };

        $sql = "SELECT a.*
            FROM articles a
            JOIN article_category ac ON ac.article_id = a.id
            WHERE ac.category_id = :category_id
            ORDER BY $orderBy
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function counter(int $categoryId): int
    {
        $db = DB::getInstance();

        $stmt = $db->prepare("
            SELECT COUNT(*) 
            FROM article_category 
            WHERE category_id = :category_id
        ");

        $stmt->execute(['category_id' => $categoryId]);

        return (int)$stmt->fetchColumn();
    }

    public static function find(int $id): ?array
    {
        $db = DB::getInstance();

        $stmt = $db->prepare("SELECT * FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        return $article ?: null;
    }

    public static function increaseViewsNumber(int $id): void
    {
        $db = DB::getInstance();

        $stmt = $db->prepare("UPDATE articles SET views = views + 1 WHERE id = :id");

        $stmt->execute(['id' => $id]);
    }

    public static function similarBlogs(int $articleId, int $limit = 3): array
    {
        $db = DB::getInstance();

        $sql = "
            SELECT DISTINCT a.*
            FROM articles a
            JOIN article_category ac ON ac.article_id = a.id
            WHERE ac.category_id IN (
                SELECT category_id 
                FROM article_category 
                WHERE article_id = :article_id
            )
            AND a.id != :article_id
            ORDER BY a.published_at DESC
            LIMIT :limit
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        // proverka

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
