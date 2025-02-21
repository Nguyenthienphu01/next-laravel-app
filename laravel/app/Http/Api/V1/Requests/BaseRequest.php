<?php
/**
 * Class BaseRequest
 * @author PhuNguyen
 * @since 2023-09-07
 */
namespace App\Http\Api\V1\Requests;

use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @author PhuNguyen
     * @since 2023-09-07
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @author PhuNguyen
     * @since 2023-09-07
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
    /**
     * Get the validation messages that apply to the request.
     *
     * @author PhuNguyen
     * @since 2023-09-07
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
    /**
     * Get the validation attributes that apply to the request.
     *
     * @author PhuNguyen
     * @since 2023-09-07
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }
    /**
     * Get the "after" validation callables for the request.
     *
     * @author PhuNguyen
     * @since 2023-09-07
     * @return array
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
            },
        ];
    }
    /**
     * Validation failed response
     * @author PhuNguyen
     * @since 2023-09-07
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->getMessages();
        $obj = $validator->failed();
        foreach($obj as $input=>$rule) {   
            $error_code =  config('constants.ERROR_CODE.'.$errors[$input][0]);
            if($error_code) {
                throw new ValidationException($validator, response()-> json([
                    'code' => $error_code,
                    'message' => __('common.'.$errors[$input][0]),
                    'data' => (object) []],
                    400));
            } else {
                throw new ValidationException($validator, response()-> json([
                    'code' => !empty(config('constants.ERROR_CODE.'.$input.".".strtolower(array_key_first($rule))))?
                    config('constants.ERROR_CODE.'.$input.".".strtolower(array_key_first($rule))):'error',
                    'message' => $errors[$input][0],
                    'data' => (object) []],
                    400));
            }
            
        }
    }
}