<?php declare(strict_types=1);

namespace App\Models;

use \PDO;
use Core\Model;

class Post extends Model
{
    public static function all(): array
    {
        // $db = static::getDB();

        // $stmt = $db->query('SELECT * FROM posts');
        
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            ['id' => 101, 'title' => 'Facebook', 'author' => '@saah'],
            ['id' => 102, 'title' => 'Twitter', 'author' => '@dory'],
            ['id' => 103, 'title' => 'Google', 'author' => '@dave'],
        ];
    }
}
