<?php

declare(strict_types=1);

namespace App\Validator;

class LoginValidator
{
    private const EMPTY_FIELD_ERROR = '%s should be present';

    public function validate(array $body): ?string
    {
        if (empty(trim($body['email'] ?? ''))) {
            return sprintf(self::EMPTY_FIELD_ERROR, 'email');
        }

        if (empty(trim($body['password'] ?? ''))) {
            return sprintf(self::EMPTY_FIELD_ERROR, 'password');
        }

        return null;
    }
}
