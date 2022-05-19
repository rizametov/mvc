<?php declare(strict_types=1);

namespace App\Models;

use \PDO;
use Core\Model;
use App\Token;
use App\Mail;
use App\MailService;

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
        $this->validate();

        if (empty($this->errors)) {
            $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

            $token = new Token();
            $activationHash = $token->getHash();

            $this->activation_token = $token->getToken();

            $sql = 'INSERT INTO users (name, email, password_hash, activation_hash)
                    VALUES (:name, :email, :password_hash, :activation_hash)';

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
            $stmt->bindValue(':activation_hash', $activationHash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    private function validate(): void
    {
        foreach ($this as $property => $value) {
            if ($this->$property === '') {
                $this->errors[] = ucfirst($property) . ' is required';
            }
        }

        if (false === filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Invalid email';
        }

        $this->passwordValidate();

        if (true === $this->emailExists($this->email)) {
            $this->errors[] = 'Email is already exist';
        }
    }

    private function passwordValidate(): void
    {
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
    }

    public function emailExists(string $email): bool
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

    public static function getByToken(string $token): self|bool
    {
        $token = new Token($token);
        $passwordResetHash = $token->getHash();

        $sql = 'SELECT * FROM users
                WHERE password_reset_hash = :password_reset_hash';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':password_reset_hash', $passwordResetHash, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $user = $stmt->fetch();

        return strtotime($user->password_reset_expires_at) > time() ? $user : false;   
    }

    public function resetPassword(string $password, string $passwordConfirmation): bool
    {
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;

        $this->passwordValidate();
        
        if (empty($this->errors)) {
            $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'UPDATE users 
                    SET password_hash = :password_hash, 
                        password_reset_hash = NULL, 
                        password_reset_expires_at = NULL
                    WHERE id = :id';

            $db = static::getDB();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        return false;
    }

    public function sendPasswordReset(): void
    {
        if (false !== $this->startPasswordReset())
        {
            $this->sendPasswordResetEmail();
        }
    }

    private function startPasswordReset(): bool
    {
        $token = new Token();
        $tokenHash = $token->getHash();
        $this->password_reset_token = $token->getToken();
        
        $expiryTimestamp = time() + 60 * 60 * 2;

        $sql = 'UPDATE users
                SET password_reset_hash = :password_reset_hash,
                    password_reset_expires_at = :password_reset_expires_at
                WHERE id = :id';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':password_reset_hash', $tokenHash, PDO::PARAM_STR);
        $stmt->bindValue(
            ':password_reset_expires_at', 
            date('Y-m-d H:i:s', $expiryTimestamp), 
            PDO::PARAM_STR
        );
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    private function sendPasswordResetEmail(): void
    {
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;

        $text = 'Click on following url to reset your password: ' . $url;

        $html = 'Click the <a href="' . $url .'">here</a> to reset your password.';

        file_put_contents('reset-password.html', $html);

        (new Mail(new MailService()))->send(
            $this->email,
            'Password Reset',
            $text,
            $html
        );
    }

    public function sendActivationEmail(): void
    {
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/signup/activate/' . $this->activation_token;

        $text = 'Click on following url to activate your account: ' . $url;

        $html = 'Click the <a href="' . $url .'">here</a> to activate your account.';

        file_put_contents('account-activate.html', $html);

        (new Mail(new MailService()))->send(
            $this->email,
            'Account activation',
            $text,
            $html
        );
    }

    public static function activateAccount(string $token): bool
    {
        $token = new Token($token);
        $activationHash = $token->getHash();

        $sql = 'UPDATE users
                SET is_active = 1,
                    activation_hash = NULL
                WHERE activation_hash = :activation_hash';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':activation_hash', $activationHash, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
