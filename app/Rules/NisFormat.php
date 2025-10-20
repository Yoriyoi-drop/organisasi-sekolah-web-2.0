<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NisFormat implements Rule
{
    public function passes($attribute, $value): bool
    {
        $v = preg_replace('/\D/', '', (string) $value);
        // Common NIS length varies, accept 8-12 digits; adjust as needed
        $len = strlen($v);
        return $len >= 8 && $len <= 12;
    }

    public function message(): string
    {
        return 'Format NIS tidak valid (8-12 digit).';
    }
}
