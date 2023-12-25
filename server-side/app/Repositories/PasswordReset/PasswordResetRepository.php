<?php

namespace App\Repositories\PasswordReset;

use App\Models\PasswordReset\PasswordReset;
use App\Repositories\Base\BaseRepository;

class PasswordResetRepository extends BaseRepository
{
    public $model = PasswordReset::class;

    public function getByTokenAndEmail(string $token, string $email)
    {
        return $this->model::where('token', $token)
            ->where('email', $email)->first();
    }

    public function getByEmail(string $email)
    {
        return $this->model::where('email', $email)->first();
    }

    public function deleteByEmail ( string $email) {
        return $this->model::where('email', $email)->delete();
    }

    public function deleteByToken ( string $token) {
        return $this->model::where('token', $token)->delete();
    }



}
