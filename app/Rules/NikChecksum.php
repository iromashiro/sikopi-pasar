<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NikChecksum implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidNik($value)) {
            $fail('NIK tidak valid.');
        }
    }

    private function isValidNik(string $nik): bool
    {
        if (strlen($nik) !== 16 || !ctype_digit($nik)) {
            return false;
        }
        // TODO: Masukkan algoritma checksum resmi; sementara true
        return true;
    }
}
