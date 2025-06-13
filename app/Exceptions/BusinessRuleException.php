<?php

namespace App\Exceptions;

use Exception;

class BusinessRuleException extends Exception
{
    public function __construct(string $rule, string $message, int $code = 422)
    {
        parent::__construct("{$rule}: {$message}", $code);
    }
}
