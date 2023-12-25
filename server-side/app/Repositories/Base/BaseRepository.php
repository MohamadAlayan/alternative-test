<?php

namespace App\Repositories\Base;


use App\Filters\Base\BaseFilter;
use App\Http\Requests\Base\ListRequest;
use App\Http\Response;
use App\Models\Base\BaseModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseRepository
{
    public $model = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        // check if the model is set or if mode is invalid
        if (!$this->model || !class_exists($this->model)) {
            throw new Exception(__('messages.invalid_model_for_repo'));
        }

        // Instantiate the model class to be used by the repository
        $this->model = new $this->model;
    }

    /**
     * this method is used to create a new record
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * this method is used to add multiple records
     * @param array $data
     * @return mixed
     */
    public function insert(array $data): mixed
    {
        return $this->model->insert($data);
    }

    /**
     * this method is used to update a record by id
     * @param array $data
     * @param $id
     * @param array $where
     * @return mixed
     */
    public function updateById(array $data, $id, array $where = []): mixed
    {
        return $this->model->where($where)->where('id', $id)->update($data);
    }

    /**
     * this method is used to update a record by uuid
     * @param array $data
     * @param $uuid
     * @param array $where
     * @return mixed
     */
    public function updateByUuid(array $data, $uuid, array $where = []): mixed
    {
        return $this->model->where($where)->where('uuid', $uuid)->update($data);
    }

    /**
     * this method is used to create or update a record
     * @param array $data
     * @param array $where
     * @return mixed
     */
    public function updateOrCreate(array $data, array $where = []): mixed
    {
        return $this->model->updateOrCreate($where, $data);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function where(array $where = []): mixed
    {
        return $this->model->where($where);
    }

    /**
     * this method is used to count records
     * @param array $where
     * @return mixed
     */
    public function count(array $where = []): mixed
    {
        return $this->model->where($where)->count();

    }

    /**
     * this method is used to delete a record
     * @param $id
     * @param string $uuid
     * @param array $where
     * @return mixed
     */
    public function delete($id, string $uuid, array $where = []): mixed
    {
        return $this->model->where($where)->where('id', $id)->orWhere('uuid', $uuid)->delete();
    }

    /**
     * this method is used to force delete a record
     * @param $id
     * @param string $uuid
     * @param array $where
     * @return mixed
     */
    public function forceDelete($id, string $uuid, array $where = []): mixed
    {
        return $this->model->where($where)->where('id', $id)->orWhere('uuid', $uuid)->forceDelete();
    }

    /**
     * this method is used to restore a record
     * @param $id
     * @param string $uuid
     * @param array $where
     * @return mixed
     */
    public function restore($id, string $uuid, array $where = []): mixed
    {
        return $this->model->where($where)->where('id', $id)->orWhere('uuid', $uuid)->restore();
    }

    /**
     * @throws Exception
     */
    public function all(ListRequest $request, BaseFilter $filter = null, array $where = [])
    {
        $search = $request->search ? strtolower(trim($request->search)) : null;
        $sort_by = $request->sort_by ? strtolower(trim($request->sort_by)) : null;
        $isDescending = filter_var($request->is_descending, FILTER_VALIDATE_BOOLEAN);

        if (!is_subclass_of($this->model, BaseModel::class)) {
            throw new Exception("Model must extend ListingModel to be able to use with BaseRepository->paginate method, {$this->model} should extend ListingModel and implement its methods");
        }

        $query = $this->model::list()->filter($filter)->sort($sort_by, $isDescending)->search($search);
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }
        return $query;
    }

    public function list(ListRequest $request, BaseFilter $filter = null, array $where = [], $responseWrapper = true)
    {
        $models = $this->all($request, $filter, $where)->paginate($this->getPerPage($request));
        $models->setCollection($models->getCollection()->makeHidden($this->model::$hideInList));
        return $responseWrapper ? Response::successWithPagination($models) : $models;
    }

    /**
     * get per_page
     *
     * @param Request $request
     * @return number
     */
    public function getPerPage(Request $request): int
    {
        $per_page = $request->input('per_page') ?: 10;
        if ($per_page > 100) {
            $per_page = 100;
        }
        return $per_page;
    }

    /**
     * this method is used to get a record
     * @param $id
     * @param array $where
     * @return mixed
     */
    public function getById($id, array $where = []): mixed
    {
        return $this->model->where($where)->where('id', $id)->first();
    }

    /**
     * this method is used to get a record by uuid
     * @param $uuid
     * @param array $where
     * @return mixed
     */
    public function getByUuid($uuid, array $where = []): mixed
    {
        return $this->model->where($where)->where('uuid', $uuid)->first();
    }

}
