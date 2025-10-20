<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NikFormat implements Rule
{
    public function passes($attribute, $value): bool
    {
        $v = preg_replace('/\D/', '', (string) $value);
        // Indonesia NIK typically 16 digits
        return strlen($v) === 16;
    }

    public function message(): string
    {
        return 'Format NIK tidak valid (harus 16 digit).';
    }
}
