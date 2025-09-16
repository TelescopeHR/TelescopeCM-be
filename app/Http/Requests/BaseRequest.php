<?php

namespace App\Http\Requests;

use App\Support\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    private array $additionalRules = [];

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return collect($this->additionalRules)->isEmpty()
            ? []
            : $this->additionalRules;
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->validator->errors();

        throw new HttpResponseException(
            ApiResponse::failedValidation($errors->first())
        );
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (){
            //insert rule inside
        });
    }

    public function addNewRuleSets(array $rules)
    {
        $this->additionalRules = collect($this->rules())->merge($rules)->toArray();
    }
}
