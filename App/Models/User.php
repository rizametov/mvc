<?php declare(strict_types=1);

namespace App\Models;

use \PDO;

class User extends \Core\Model
{
    private array $errors = [];

    public function __construct(array $data)
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

    private function emailExists(string $email): bool
    {
        $sql = 'SELECT email FROM users WHERE email = :email';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->execute();

        return false !== $stmt->fetch(); 
    }
}
