<?php

namespace App\Repositories\RoleAndPermission;

use App\Models\RoleAndPermission\Role;
use App\Repositories\Base\BaseRepository;

class RoleRepository extends BaseRepository
{
    public $model = Role::class;

}
