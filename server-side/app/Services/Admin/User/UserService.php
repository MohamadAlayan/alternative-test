<?php

namespace App\Services\Admin\User;

use App\Enums\AttachmentType;
use App\Enums\HttpCode;
use App\Enums\UserType;
use App\Filters\User\UserFilter;
use App\Helpers\FileHelper;
use App\Http\Requests\Admin\User\CreateAdminRequest;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\ListAdminRequest;
use App\Http\Requests\Admin\User\ListUserRequest;
use App\Mail\CreateAdminAccountMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\User\UpdateAdminRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Response;
use App\Models\User\User;
use App\Repositories\RoleAndPermission\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Services\Base\BaseService;
use Exception;

class UserService extends BaseService
{
    public $repository = UserRepository::class;

    protected RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        parent::__construct();
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param ListAdminRequest $listAdminRequest
     * @param UserFilter $userFilter
     * @return mixed
     */
    public function listAdmins(ListAdminRequest $listAdminRequest, UserFilter $userFilter): mixed
    {
        return $this->repository->list($listAdminRequest, $userFilter, [
            'type' => UserType::ADMIN->value
        ]);
    }

    /**
     * @throws Exception
     */
    public function createAdmin(CreateAdminRequest $createAdminRequest): \Illuminate\Http\JsonResponse
    {
        // prepare data
        $data = [
            'first_name' => strtolower(trim($createAdminRequest->input('first_name'))),
            'last_name' => strtolower(trim($createAdminRequest->input('last_name'))),
            'country_code' => strtolower(trim($createAdminRequest->input('country_code'))),
            'phone_number' => strtolower(trim($createAdminRequest->input('phone_number'))),
            'email' => strtolower(trim($createAdminRequest->input('email'))),
            'password' => trim($createAdminRequest->input('password')),
            'status' => $createAdminRequest->input('status'),
            'type' => UserType::ADMIN->value,
        ];

        // create user
        $user = $this->repository->create($data);

        // assign role
        $role = $this->roleRepository->getById($data['role_id']);
        $user->assignRole($role->name);

        //  Upload image
        if ($createAdminRequest->hasFile('image')) {
            $att = FileHelper::uploadImage(
                $createAdminRequest->file('image'),
                $user->id,
                AttachmentType::PROFILE_IMAGE->value,
                true
            );
        }

        // Send email
        if ($createAdminRequest->input('send_email')) {
            Mail::to($data['email'])->send(new CreateAdminAccountMail($user, $data['password']));
        }

        return Response::success(__('messages.admin_created_successfully'), $user);
    }

    public function readAdmin($uuid): \Illuminate\Http\JsonResponse
    {
        $user = $this->repository->getByUuid($uuid);

        if (!$user) {
            return Response::error(__('messages.user_not_found'), HttpCode::NOT_FOUND->value);
        }

        return Response::success(__('messages.fetch_success'), $user);
    }

    public function updateAdmin($uuid, UpdateAdminRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = $this->repository->getByUuid($uuid);

        if (!$user) {
            return Response::error(__('messages.user_not_found'), HttpCode::NOT_FOUND->value);
        }

        $user->update([]);

        return Response::success(__('messages.update_success'), $this->repository->getFirstByUuid($uuid));
    }

    public function deleteAdmin($uuid): \Illuminate\Http\JsonResponse
    {
        $user = $this->repository->getByUuid($uuid);

        if (!$user) {
            return Response::error(__('messages.user_not_found'), HttpCode::NOT_FOUND->value);
        }

        if (!$user->delete()) {
            return Response::error(__('messages.delete_failed'), HttpCode::INTERNAL_SERVER_ERROR->value);
        }

        return Response::success(__('messages.delete_success'));
    }

    public function listUsers(ListUserRequest $request, UserFilter $userFilter)
    {
        return $this->repository->list($request, $userFilter, [
            'type' => UserType::USER->value
        ]);
    }

    public function createUser(CreateUserRequest $request)
    {
        // implementation here...
    }

    public function readUser($uuid)
    {
        // implementation here...
    }

    public function updateUser(UpdateUserRequest $request)
    {
        // implementation here...
    }

    public function deleteUser($uuid): \Illuminate\Http\JsonResponse
    {

        /** @var User $user */
        $user = $this->repository->where(['uuid' => $uuid])->first();
        if (!$user) {
            return Response::error(__('messages.user_not_found'), HttpCode::BAD_REQUEST->value);
        }

        // if user has role , delete not allowed
        if ($user->isAdmin()) {
            return Response::error(__('messages.request_is_unauthorized'), HttpCode::UNAUTHORIZED->value);
        }

        try {
            $user->delete();
            return Response::success(__('messages.delete_success'));
        } catch (Exception $e) {
            return Response::error(__('messages.delete_failed'), HttpCode::INTERNAL_SERVER_ERROR->value);
        }

    }
}
