<?php
/**
 * Class BaseRepositoryEloquent
 * @author PhuNguyen
 * @since 2023-09-07
 */
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

use DB;
use Log;
use Exception;

class BaseRepositoryEloquent implements BaseRepository
{
    protected $querySearchTargets = [];
    protected $selectedFields = [];

    /**
     * Get model
     * @author PhuNguyen
     * @since 2023-09-07
     * @return Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\Model
     */
    public function model(): Collection|Model
    {
        return new Collection();
    }
    /**
     * Create record
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $data
     * @param bool $isRollback
     * @return Illuminate\Database\Eloquent\Model | bool
     */
    public function create(array $data): Model|bool
    {
        try {
            if (count($data) === count($data, COUNT_RECURSIVE)) { // One dimensional -> change to multi dimensional
                $data = [$data];
            }
            foreach ($data as $row) {
                $row['CreatedAt'] = now();
                $row['UpdatedAt'] = now();

                $model = $this->model();
                $model = $model->fill($row);
                $model->save();
            }
            return $model;
        } catch (Exception $e) {
            Log::error('=======================CREATE ' . strtoupper($this->model()->getTable()) . ' ERROR=======================');
            Log::error($e->getMessage());
            
            return false;
        }
    }
    /**
     * Update record
     * @author PhuNguyen
     * @since 2023-09-07
     * @param int $id
     * @param array $data
     * @return Illuminate\Database\Eloquent\Model | bool
     */
    public function update(int $id, array $data): Model|bool
    {
        try {
            $model = $this->model()->whereId($id)->first();
            $data['UpdatedAt'] = now();
            $model = $model->fill($data);
            $model->save();

            return $model;
        } catch (Exception $e) {
            Log::error('=======================UPDATE ' . strtoupper($this->model()->getTable()) . ' ERROR=======================');
            Log::error($e->getMessage());

            return false;
        }
    }
    /**
     * All by filter
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @param string|array $order
     * @param string|array $direction
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function allByFilter(array $filter = [], string $order = '', string $direction = ''): Collection
    {
        $query = $this->buildQueryByFilter($filter);
        $query = $this->buildOrder($query, $order, $direction);

        return $query->get();
    }
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
    public function paginateByFilter(array $filter, string $order = '', string $direction = '', int $limit, string $pageName = 'page', int $page): LengthAwarePaginator
    {
        $query = $this->buildQueryByFilter($filter);
        $query = $this->buildOrder($query, $order, $direction);

        return $query->paginate($limit, ['*'], $pageName);
    }
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
    public function getByFilter(array $filter, string $order = '', string $direction = '', int $offset = 0, int $limit): Collection
    {
        $limit = $limit ?? config('constants.DEFAULT_LIMIT_PAGING');
        $query = $this->buildQueryByFilter($filter);
        $query = $this->buildOrder($query, $order, $direction);
        return $query->skip($offset)->take($limit)->get();
    }
    /**
     * Count by filter
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @return int
     */
    public function countByFilter(array $filter): int
    {
        $query = $this->buildQueryByFilter($filter);

        return $query->count();
    }
    /**
     * First by filter
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @return Illuminate\Database\Eloquent\Model|null
     */
    public function firstByFilter(array $filter): ?Model
    {
        $query = $this->buildQueryByFilter($filter);

        return $query->first();
    }
    /**
     * Delete by filter
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @return bool
     */
    public function deleteByFilter(array $filter): bool
    {
        $query = $this->buildQueryByFilter($filter);

        return $query->delete();
    }

    /**
     * Build query by filter
     *
     * @author PhuNguyen
     * @since 2023-09-07
     * @param array $filter
     * @return Illuminate\Database\Query\Builder
     */
    protected function buildQueryByFilter(array $filter): Builder
    {
        $query = $this->model()->from($this->model()->getTable());

        if (count($this->querySearchTargets) > 0 && array_key_exists('query', $filter)) {
            $searchWord = data_get($filter, 'query');
            if (!empty($searchWord)) {
                $query = $query->where(function ($q) use ($searchWord) {
                    foreach ($this->querySearchTargets as $index => $target) {
                        if ($index === 0) {
                              $q = $q->where($target, 'LIKE', '%' . $searchWord . '%');
                        } else {
                              $q = $q->orWhere($target, 'LIKE', '%' . $searchWord . '%');
                        }
                    }
                });
            }
            unset($filter['query']);
        }

        if (array_key_exists('like', $filter)) {
            $params = data_get($filter, 'like');
            $query = $query->where(function ($q) use ($params) {
                foreach ($params as $column => $target) {
                    $q = $q->orWhere($column, 'LIKE', '%'.$target.'%');
                }
            });
            unset($filter['like']);
        }

        if (array_key_exists('whereNotIn', $filter)) {
            $params = data_get($filter, 'whereNotIn');
            foreach ($params as $column => $values) {
                if (is_array($values)) {
                    $query = $query->whereNotIn($column, $values);
                }
            }
            unset($filter['whereNotIn']);
        }
        if (array_key_exists('operator', $filter)) {
            $params = data_get($filter, 'operator');
            foreach ($params as $operator => $conditions) {
                if (is_array($conditions)) {
                    foreach ($conditions as $column => $value) {
                        $query = $query->where($column, $operator, "$value");
                    }
                }
            }
            unset($filter['operator']);
        }

        if (array_key_exists('raw', $filter)) {
            $raw = data_get($filter, 'raw');
            $query = $query->whereRaw($raw['sql'], $raw['params']);
            unset($filter['raw']);
        }

        if (array_key_exists('groupBy', $filter)) {
            $query = $query->groupBy(data_get($filter, 'groupBy'));
            unset($filter['groupBy']);
        }

        if (array_key_exists('withTrashed', $filter)) {
            $query = $query->withTrashed();
            unset($filter['withTrashed']);
        }

        foreach ($filter as $column => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($column, $value);
                continue;
            }
            $query = $query->where($column, $value);
        }
        return $query;
    }

    /**
     * Build order by in query
     *
     * @author PhuNguyen
     * @since 2023-09-07
     * @param Illuminate\Database\Query\Builder $query
     * @param string|array $order
     * @param string|array $direction
     *
     * @return Illuminate\Database\Query\Builder
     */
    protected function buildOrder(Builder $query, string|array $order, string|array $direction): Builder
    {
        if (!empty($order)) {
            if (is_array($order) && is_array($direction)) {
                foreach ($order as $key => $value) {
                    if (in_array($value, $this->model()->getFillable())) {
                        $sortCondition = isset($direction[$key]) ? $direction[$key] : 'asc';
                        $query = $query->orderBy($value, $sortCondition);
                    }
                }
                return $query;
            }
            if (in_array($order, $this->model()->getFillable())) {
                $direction = empty($direction) ? 'asc' : $direction;
                $query = $query->orderBy($order, $direction);
            }
        }
        return $query;
    }
    /**
     * Get raw sql string
     * @author PhuNguyen
     * @since 2023-09-07
     * @param Illuminate\Database\Query\Builder $query
     * @return string
     */
    protected function getRawSql(Builder $query): string
    {
        $sql = $query->toSql();

        foreach ($query->getBindings() as $value) {
            if (is_string($value)) {
                $sql = preg_replace('/\?/', "'{$value}'", $sql, 1);
                continue;
            }
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }
}