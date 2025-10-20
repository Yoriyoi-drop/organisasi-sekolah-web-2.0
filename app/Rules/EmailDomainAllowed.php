<?php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class EmailDomainAllowed implements Rule, DataAwareRule
{
    protected array $data = [];

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value): bool
    {
        $parts = explode('@', (string) $value);
        if (count($parts) !== 2) {
            return false;
        }
        [$local, $domain] = $parts;
        $domain = strtolower(trim($domain));
        $allowed = array_map('strtolower', config('auth.allowed_domains', []));
        return in_array($domain, $allowed, true);
    }

    public function message(): string
    {
        return 'Domain email tidak diizinkan.';
    }
}
