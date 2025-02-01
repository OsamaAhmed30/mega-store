<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Filter implements ValidationRule
{

    protected $forbidden;

    function __construct($forbidden)
    {
        $this->forbidden=strtolower($forbidden);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail):void
    {
        if ((strtolower($value) == $this->forbidden)) {
            $fail('This Value is Not Allowed');
        }
       
    }

}
