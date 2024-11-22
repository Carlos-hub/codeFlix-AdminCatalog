<?php

namespace Core\Domain\Validation;
use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    public static function notNull(string $value, string $message = null)
    {
        if (empty($value)) {
            throw new EntityValidationException($message ?? 'Should not be empty');
        }
    }

    public static function strMaxLength(string $value, int $length  = 255, string $message = null)
    {
        if (strlen($value) >= $length) {
            throw new EntityValidationException($message ?? 'Should not be greater than '.$length);
        }
    }

    public static function strMinLength(string $value, int $length  = 2, string $message = null)
    {
        if (strlen($value) < $length) {
            throw new EntityValidationException($message ?? 'Should not be greater than '.$length);
        }
    }
}
