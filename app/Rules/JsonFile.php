<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class JsonFile implements ValidationRule {

    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (($value instanceof \Illuminate\Http\UploadedFile) && $value->getClientOriginalExtension() != 'json' && !in_array($value->getMimeType(), ["application/json", "text/plain"])) {
            $fail($attribute . ' must be a json file');
        }
    }
}
