<?php

namespace App\Models\Attachment;

use App\Models\Base\BaseModel;

class AttachmentCategory extends BaseModel
{
    protected $table = 'attachment_categories';

    protected $fillable = [
        'uuid',
        'name',
        'description',
    ];

    public function attachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}
