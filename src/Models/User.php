<?php

namespace Core\Models;

use Core\Session;
use PDO;
use RangeException;

class User extends Model
{
    protected const SESSION_KEY = 'username';

    public static function tableName(): string
    {
        return 'users';
    }

    public static function columns(): array
    {
        return [
            'login',
            'password',
        ];
    }

    public static function logIn(string $username, string $password): ?self
    {
        if (self::isLoggedIn()) {
            return self::new(['username' => $username]);
        }

        $users = self::where('username', $username);

        if (count($users) > 1) {
            throw new RangeException('Found too many users with login ' . $username);
        } elseif (empty($users)) {
            return null;
        }

        $user = $users[0];

        if (password_verify($password, $user->password)) {
            Session::start()->set(self::SESSION_KEY, $username);

            return $user;
        }

        return null;
    }

    public static function isLoggedIn(): bool
    {
        return Session::start()->has(self::SESSION_KEY);
    }

    public static function logOut(): void
    {
        if (!self::isLoggedIn()) {
            return;
        }

        Session::start()->unset(self::SESSION_KEY);
    }

    public function __set(string $name, $value)
    {
        if ($name === 'password' && password_needs_rehash($value, PASSWORD_BCRYPT)) {
            $value = password_hash($value, PASSWORD_BCRYPT);
        }

        parent::__set($name, $value);
    }
}