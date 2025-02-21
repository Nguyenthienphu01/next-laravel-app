<?php

namespace App\Http\Api\V1\Controllers;

use App\Repositories\AdminRepository;

use Illuminate\Http\Request;
use App\Http\Api\V1\Requests\Account\AccountCreateRequest;
use App\Http\Api\V1\Requests\Account\AccountUpdateRequest;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;



/**
 * Class AccountController
 * @author PhuNguyen
 * @since 2025-01-17
 */
class AccountController extends BaseController
{

    protected AdminRepository $adminRepository;

    public function __construct(
        AdminRepository $adminRepository,
    ) {
        $this->adminRepository = $adminRepository;
    }

    /**
     * create
     * @feature create account
     * @method POST
     * @author PhuNguyen
     * @since 2025-01-17
     */
    public function createAccount(AccountCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $adminData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'role' => $request->role,
            ];

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Store the file and get the path
                $path = $file->storeAs('public/uploads/admin', $fileName);

                if ($path) {
                    $adminData['image'] = 'uploads/admin/' . $fileName;
                }
            }

            $data = $this->adminRepository->create($adminData);

            DB::commit();
            return $this->responseSuccess([$data]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create admin:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->responseError(__('common.common_failed'));
        }
    }

    /**
     * update
     * @feature update account
     * @method POST
     * @author PhuNguyen
     * @since 2025-01-17
     */
    public function updateAccount(AccountUpdateRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Find admin using firstByFilter
            $admin = $this->adminRepository->firstByFilter(['id' => $id]);
            if (!$admin) {
                return $this->responseError(__('common.common_failed'));
            }

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];

            // Only update password if it's provided
            if ($request->filled(key: 'password')) {
                $updateData['password'] = bcrypt(value: $request->password);
            }

            // Only update role if it's provided
            if ($request->filled(key: 'role')) {
                $updateData['role'] = $request->role;
            }

            // Handle image upload if present
            if ($request->hasFile(key: 'image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Delete old image if exists
                if ($admin->image) {
                    $oldImagePath = storage_path('app/public/' . $admin->image);
                    if (file_exists(filename: $oldImagePath)) {
                        unlink(filename: $oldImagePath);
                    }
                }

                // Store new image
                $file->storeAs(path: 'public/uploads/admin', name: $fileName);
                $updateData['image'] = 'uploads/admin/' . $fileName;
            }

            // Update admin using firstByFilter
            $admin->update($updateData);
            $data = $this->adminRepository->firstByFilter(['id' => $id]);

            DB::commit();
            return $this->responseSuccess([$data]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return $this->responseError(__('common.common_failed'));
        }
    }

    /**
     * update
     * @feature list account
     * @method GET
     * @author PhuNguyen
     * @since 2025-01-17
     */
    public function listAccount(Request $request): JsonResponse
    {
        try {
            $filter = [
                'search' => $request->query('search', ''),
                'role' => $request->query('role', ''),
                'sort_field' => $request->query('sort_field', 'created_at'),
                'sort_order' => $request->query('sort_order', 'desc'),
            ];

            $page = $request->query('page', 1);
            $limit = $request->query('per_page', 10);

            $data = $this->adminRepository->paginateByFilter($filter, "", "", $limit, "", $page);

            return $this->responseSuccess($data->toArray());
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->responseError(__('common.common_failed'));
        }
    }

    /**
     * delete
     * @feature delete account
     * @method DELETE
     * @author PhuNguyen
     * @since 2025-01-17
     */
    public function deleteAccount(Request $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $admin = $this->adminRepository->firstByFilter(['id' => $id]);
            if (!$admin) {
                return $this->responseError(message: 'Admin not found');
            }

            // Delete associated image if exists
            if ($admin->image) {
                $imagePath = storage_path('app/public/' . $admin->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete the admin
            $admin->delete($id);

            DB::commit();
            return $this->responseSuccess(message: 'Admin deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return $this->responseError(__('common.common_failed'));
        }
    }
}
