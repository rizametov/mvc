<?php declare(strict_types=1);

namespace App\Models;

use PDO;

class User extends \Core\Model
{
    public static function all(): array
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT id, name FROM users');
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}