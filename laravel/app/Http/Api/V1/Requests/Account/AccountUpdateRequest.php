<?php
/**
 * Class AccountUpdateRequest
 * @author PhuNguyen
 * @since 2025-01-10
 */
namespace App\Http\Api\V1\Requests\Account;

use App\Http\Api\V1\Requests\BaseRequest;

class AccountUpdateRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @author PhuNguyen
     * @since 2025-01-10
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email:rfc',
            ],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @author PhuNguyen
     * @since 2025-01-10
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => __('auth.email_not_found'),
            'email.email' => __('auth.invalid_email'),
            'password.required' => __('auth.password_not_found'),
        ];
    }
}
