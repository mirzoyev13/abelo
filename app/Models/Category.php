<?php

namespace App\Models;

use App\Database\DB;
use PDO;

class Category
{
    public static function getAll(): array
    {
        $db = DB::getInstance();

        $sql = "
            SELECT DISTINCT c.*
            FROM categories c
            JOIN article_category ac ON ac.category_id = c.id
            JOIN articles a ON a.id = ac.article_id
            ORDER BY c.name
        ";
        // test sql

        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $db = DB::getInstance();

        $stmt = $db->prepare(
            "SELECT * FROM categories WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category ?: null; // throw
    }
}
