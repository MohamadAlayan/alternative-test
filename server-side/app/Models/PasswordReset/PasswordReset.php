<?php

namespace App\Models\PasswordReset;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model {

    protected $table = "password_reset_tokens";

    public $timestamps = false;

    protected $fillable = [
        "email",
        "token",
        "created_at"
    ];

}
