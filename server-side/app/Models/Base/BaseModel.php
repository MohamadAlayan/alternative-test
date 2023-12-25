<?php

namespace App\Models\Base;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = AppHelper::getUuid();
            }
        });
    }

    public function scopeSearch($query, $search) {

    }


}
