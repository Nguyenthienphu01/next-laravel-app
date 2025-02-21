<?php

/**
 * Class AdminRepositoryEloquent
 * @author PhuNguyen
 * @since 2023-09-07
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Admin;

class AdminRepositoryEloquent extends BaseRepositoryEloquent implements AdminRepository
{
    /**
     * Specify Model class name
     * @author PhuNguyen
     * @since 2023-09-07
     * @return Illuminate\Database\Eloquent\Model
     */
    public function model(): Model
    {
        return new Admin();
    }

    public function paginateByFilter(array $filter, string $order = '', string $direction = '', int $limit, string $pageName = 'page', int $page): LengthAwarePaginator
    {
        $query = $this->model()->newQuery();

        // Handle search by name and email
        if (!empty($filter['search'])) {
            $query->where(function ($q) use ($filter) {
                $q->where('name', 'like', '%' . $filter['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filter['search'] . '%');
            });
        }

        // Handle search by role
        if (!empty($filter['role'])) {
            $query->where(function ($q) use ($filter) {
                $q->orWhere('role', 'like', '%' . $filter['role'] . '%');
            });
        }

        // Handle sorting
        $sortField = $filter['sort_field'] ?? 'created_at';
        $sortOrder = $filter['sort_order'] ?? 'desc';

        // Only allow specific fields for sorting
        $allowedSortFields = ['name', 'email', 'created_at'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortOrder);
        }

        return $query->paginate($limit, ['*'], 'page', $page);
    }
}
