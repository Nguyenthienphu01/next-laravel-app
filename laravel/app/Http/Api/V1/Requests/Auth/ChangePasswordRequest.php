<?php
/**
 * Class ChangePasswordRequest
 * @author PhuNguyen
 * @since 2025-01-15
 */
namespace App\Http\Api\V1\Requests\Auth;

use App\Http\Api\V1\Requests\BaseRequest;
/**
 * Get the validation rules that apply to the request.
 * @return array
 * @since 2025-01-15
 * @author PhuNguyen
 */
class ChangePasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
            ],
        ];
    }
}
