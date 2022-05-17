<?php declare(strict_types=1);

namespace App\Models;

use \PDO;
use Core\Model;
use App\Token;

class User extends Model
{
    private array $errors = [];

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public static function all(): array
    {
        $db = static::getDB();

        $stmt = $db->query('SELECT id, name FROM users');
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(): bool
    {
        if (true === $this->validate()) {
            $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (name, email, password_hash)
                    VaLUES (:name, :email, :password_hash)';

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    private function validate(): bool
    {
        foreach ($this as $property => $value) {
            if ($this->$property === '') {
                $this->errors[] = ucfirst($property) . ' is required';
            }
        }

        if (false === filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Invalid email';
        }

        if ($this->password !== $this->passwordConfirmation) {
            $this->errors[] = 'Password must match confirmation';
        }

        if (strlen($this->password) < 6) {
            $this->errors[] = 'Please enter at least 6 characters for the password';
        }

        if (0 === preg_match('/.*[a-z].*/i', $this->password)) {
            $this->errors[] = 'Password needs at least one letter';
        }

        if (0 === preg_match('/.*\d+.*/i', $this->password)) {
            $this->errors[] = 'Password needs at least one number';
        }

        if (true === $this->emailExists($this->email)) {
            $this->errors[] = 'Email is already exist';
        }

        return empty($this->errors);
    }

    public static function emailExists(string $email): bool
    {
        return false !== static::getByEmail($email);
    }

    public static function getById(int $id): self|bool
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function getByEmail(string $email): self|bool
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function authenticate(string $email, string $password): self|bool
    {
        $user = static::getByEmail($email);

        if (false !== $user) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
        }

        return false;
    }

    public function rememberLogin(): bool
    {
        $token = new Token();

        $this->token = $token->getToken();
        $this->tokenHash = $token->getHash();

        $this->expiresAt = time() + 60 * 60 * 24 * 30;

        $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                VALUES (:token_hash, :user_id, :expires_at)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $this->tokenHash, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiresAt), PDO::PARAM_STR);

        return $stmt->execute();
    }
}
