<?php

declare(strict_types=1);

namespace App\Service;

class SessionManager
{
    public function __construct()
    {
        session_cache_limiter('nocache');
        session_start();
    }

    public function flash(string $key): mixed
    {
        $value = $_SESSION[$key] ?? null;
        unset($_SESSION[$key]);

        return $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }
}
