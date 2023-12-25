<?php

namespace App\Http\Controllers\Admin;

use App\Filters\User\UserFilter;
use App\Helpers\FilterHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateAdminRequest;
use App\Http\Requests\Admin\User\CreateUserRequest;
//use App\Http\Requests\Admin\User\DeleteAdminRequest;
//use App\Http\Requests\Admin\User\DeleteUserRequest;
use App\Http\Requests\Admin\User\ListAdminRequest;
use App\Http\Requests\Admin\User\ListUserRequest;
//use App\Http\Requests\Admin\User\ReadAdminRequest;
//use App\Http\Requests\Admin\User\ReadUserRequest;
use App\Http\Requests\Admin\User\UpdateAdminRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Services\Admin\User\UserService;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    // Admin CRUD
    public function listAdmins(ListAdminRequest $listAdminRequest)
    {
        $userFilter = FilterHelper::getFilter($listAdminRequest, UserFilter::class);
        return $this->userService->listAdmins($listAdminRequest, $userFilter);
    }

    public function createAdmin(CreateAdminRequest $createAdminRequest)
    {
        return $this->userService->createAdmin($createAdminRequest);
    }

    public function readAdmin($uuid)
    {
        return $this->userService->readAdmin($uuid);
    }

    public function updateAdmin($uuid, UpdateAdminRequest $updateAdminRequest)
    {
        return $this->userService->updateAdmin($uuid, $updateAdminRequest);
    }

    public function deleteAdmin($uuid)
    {
        return $this->userService->deleteAdmin($uuid);
    }

    // User CRUD

    public function listUsers(ListUserRequest $listUserRequest)
    {
        $userFilter = FilterHelper::getFilter($listUserRequest, UserFilter::class);
        return $this->userService->listUsers($listUserRequest, $userFilter);
    }

    public function createUser(CreateUserRequest $createUserRequest)
    {
        return $this->userService->createUser($createUserRequest);
    }

//    public function readUser(ReadUserRequest $readUserRequest)
//    {
//        return $this->userService->readUser($readUserRequest);
//    }
//
//    public function updateUser(UpdateUserRequest $updateUserRequest)
//    {
//        return $this->userService->updateUser($updateUserRequest);
//    }
//
//    public function deleteUser(DeleteUserRequest $deleteUserRequest)
//    {
//        return $this->userService->deleteUser($deleteUserRequest);
//    }

}
