<?php
/**
 * Interface BaseRepository
 * @author PhuNguyen
 * @since 2023-09-07
 */
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepository
{
    /**
     * Get model
     * @author PhuNguyen
     * @since 2023-09-07
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Model
     */
    public function model(): Collection|Model;
    /**
     * Create record
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $data
     * @return Illuminate\Database\Eloquent\Model | bool
     */
    public function create(array $data): Model|bool;
    /**
     * Update record
     * @author PhuNguyen
     * @since 2023-09-07
     * @param int $id
     * @param array $data
     * @param bool $isRollback
     * @return Illuminate\Database\Eloquent\Model | bool
     */
    public function update(int $id, array $data): Model|bool;
    /**
     * All by filter
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @param string|array $order
     * @param string|array $direction
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function allByFilter(array $filter = [], string $order = '', string $direction = ''): Collection;
    /**
     * Paginate by filter
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @param string|array $order
     * @param string|array $direction
     * @param int $limit
     * @param string $pageName
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginateByFilter(array $filter, string $order = '', string $direction = '', int $limits, string $pageName = 'page', int $page): LengthAwarePaginator;
    /**
     * Get by filter
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @param string|array $order
     * @param string|array $direction
     * @param int $offset
     * @param int $limit
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getByFilter(array $filter, string $order = '', string $direction = '', int $offset = 0, int $limit ): Collection;
    /**
     * Count by filter
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @return int
     */
    public function countByFilter(array $filter): int;
    /**
     * Get raw sql string
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @return Illuminate\Database\Eloquent\Collection|null
     */
    public function firstByFilter(array $filter): ?Model;
    /**
     * Delete by filter
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @return bool
     */
    public function deleteByFilter(array $filter): bool;
}