<?php

namespace App\Models\RoleAndPermission;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{

    protected $hidden = [
        'pivot',
    ];
}
