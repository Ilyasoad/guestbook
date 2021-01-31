<?php

namespace App\Http\FormRequest;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

abstract class AbstractRequest extends FormRequest
{
    /**
     * Validate the class instance.
     *
     * @return void
     *
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function validate(): void
    {
        $this->prepareForValidation();

        /** @var Validator $instance */
        $instance = $this->getValidatorInstance();

        if (!$this->passesAuthorization()) {
            $this->failedAuthorization();
        } elseif (!$instance->passes()) {
            $this->failedValidation($instance);
        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
