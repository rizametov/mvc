<?php declare(strict_types=1);

namespace App\Models;

use \PDO;
use Core\Model;

class Book extends Model
{
    public static function all(): array
    {
        // $db = static::getDB();

        // $stmt = $db->query('SELECT * FROM books');
        
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            ['id' => 101, 'name' => 'PHP', 'author' => '@saah'],
            ['id' => 102, 'name' => 'Java', 'author' => '@dory'],
            ['id' => 103, 'name' => 'Mysql', 'author' => '@dave'],
        ];
    }
}
