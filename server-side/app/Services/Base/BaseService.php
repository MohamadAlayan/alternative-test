<?php

namespace App\Services\Base;

use App\Http\Requests\Base\ListRequest;
use App\Repositories\Base\BaseRepository;

class BaseService
{
    public $repository = null;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        // check if the repository is set or if repository is invalid
        if (!$this->repository || !class_exists($this->repository)) {
            throw new \Exception(__('messages.invalid_repository_for_service'));
        }

        // Instantiate the repository class to be used by the service
        $this->repository = new $this->repository;
    }


    public function list(ListRequest $request)
    {
        return $this->repository->list($request);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

}
