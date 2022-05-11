<?php declare(strict_types=1);

namespace App\Models;

use Core\Model;
use \PDO;
use \PDOException;

class Post extends Model
{
    public static function all(): array
    {
        try {
            $db = static::getDB();

            $stmt = $db->query('SELECT * FROM posts');

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}