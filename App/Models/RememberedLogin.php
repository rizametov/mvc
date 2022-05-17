<?php declare(strict_types=1);

namespace App\Models;

use \PDO;
use Core\Model;
use App\Token;
use App\Models\User;

class RememberedLogin extends Model
{
    public static function getByToken(string $token): self|false
    {
        $token = new Token($token);
        $tokenHash = $token->getHash();

        $sql = 'SELECT * FROM remembered_logins WHERE token_hash = :token_hash';

        $db = static::getDB();

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $tokenHash, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public function getUser(): User|bool
    {
        return User::getById($this->user_id);
    }

    public function isExpired(): bool
    {
        return strtotime($this->expires_at) < time();
    }

    public function delete(): void
    {
        $sql = 'DELETE FROM remembered_logins WHERE token_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $this->token_hash, PDO::PARAM_STR);

        $stmt->execute();
    }
}
