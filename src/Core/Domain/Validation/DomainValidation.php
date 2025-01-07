<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{
    public static function notNull(string $value, string $exceptMessage = null): void
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptMessage ?? "should not be empty or null");
        }
    }

    public static function strMaxLength(string $value, int $length = 255, string $exceptMessage = null): void
    {
        if (strlen($value) >= $length) {
            throw new EntityValidationException($exceptMessage ?? "the value must not be greater the {$length} characters");
        }
    }

    public static function strMinLength(string $value, int $length = 3, string $exceptMessage = null): void
    {
        if (strlen($value) < $length) {
            throw new EntityValidationException($exceptMessage ?? "the value must not be less the {$length} characters");
        }
    }

    public static function strCanNullMaxLength(string $value, int $length = 255, string $exceptMessage = null): void
    {
        if (!empty($value) && strlen($value) > $length) {
            throw new EntityValidationException($exceptMessage ?? "the value must not be greater the {$length} characters");
        }
    }
}