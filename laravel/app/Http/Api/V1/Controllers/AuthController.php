<?php

namespace App\Http\Api\V1\Controllers;

use App\Repositories\AdminRepository;

use App\Http\Api\V1\Requests\Auth\LoginRequest;
use App\Http\Api\V1\Requests\Auth\ChangePasswordRequest;

use Exception;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthController
 * @author PhuNguyen
 * @since 2023-09-07
 */
class AuthController extends BaseController
{

    protected AdminRepository $adminRepository;

    public function __construct(
        AdminRepository $adminRepository,
    ) {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Login
     * @author PhuNguyen
     * @since 2023-09-07
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $admin = $this->adminRepository->firstByFilter(["email" => $request->email]);
        
            if (empty($admin)) {
                return $this->responseError(__('auth.email_not_found'));
            }
        
            if (!Hash::check($request->password, $admin->password)) {
                return response()->json(['message' => 'login failed'], 401);
            }
        
            DB::beginTransaction();
            $token = $admin->createToken('LOGIN');
            
            $data = [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'role' => $admin->role,
                'image' => $admin->image,
                'created_at' => $admin->created_at,
                'updated_at' => $admin->updated_at,
            ];
            DB::commit();
            
            return $this->responseSuccess([
                'token' => $token->plainTextToken,
                'user' => $data,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error during login: ' . $e->getMessage());
            return $this->responseError(__('common.common_failed'));
        }        
    }

    /**
     * Logout
     * @author PhuNguyen
     * @since 2025-01-15
     * @return JsonResponse
     */
    public function logout()
    {
        request()->user()->tokens()->delete();

        return $this->responseSuccess([]);
    }

    /**
     * Change Password
     * @author PhuNguyen
     * @since 2025-01-15
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!Hash::check($request['old_password'], $user->password)) {
                return response()->json(['message' => 'Old password is incorrect'], 400);
            }

            $user->password = Hash::make($request['new_password']);
            $user->save();

            return $this->responseSuccess(['message' => 'Password updated successfully']);
        } catch (Exception $e) {
            Log::error('Error during password change: ' . $e->getMessage());
            return $this->responseError(__('common.common_failed'));
        }
    }
}
