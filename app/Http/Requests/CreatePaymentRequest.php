<?php

namespace App\Http\Requests;

use App\Traits\SendResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreatePaymentRequest extends FormRequest
{
    use SendResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount'        => 'required|numeric|min:0',
            'currency'      => 'required|string',
            'order_id'      => 'required|string|exists:orders,uuid',
            // 'is_save'       => 'required|in:0,1',
            'payment_method'=> 'required',
            // 'payment_method_id'=> 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse('error', 422, $validator->errors()->first()));
    }
}
