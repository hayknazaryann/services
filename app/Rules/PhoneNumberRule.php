<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $patternAM = '/^(\+374|0)(91|94|55|93|99|98|77|41|43|95|96|97|89|88|87|86|81|80|82|83|84|85|48|49|47|46|44|45|42|70|71|72|73|74|75|76)\d{6}$/';
        $patternUSA = '/^\+1\s?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/';
        $patternFR = '/^\+33\s?[1-9](?:(?:(?:\d{2}\s?){4}\d{2})|(?:\d{8}))$/';
        $patternRU = '/^\+7\s?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{2}[-.\s]?\d{2}$/';

        if (
            !preg_match($patternAM, $value)
            && !preg_match($patternUSA, $value)
            && !preg_match($patternFR, $value)
            && !preg_match($patternRU, $value)
        ) {
            $fail('Invalid phone number ');
        }
    }
}
