<?php

namespace App\Repositories\User;

use App\Models\User\User;
use App\Repositories\Base\BaseRepository;

class UserRepository extends BaseRepository
{
    public $model = User::class;


}
