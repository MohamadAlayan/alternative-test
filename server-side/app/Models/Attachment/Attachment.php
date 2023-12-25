<?php

namespace App\Models\Attachment;

use App\Models\Base\ListingModel;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends ListingModel
{
    protected $table = 'attachments';

    protected $fillable = [
        'uuid',
        'filename',
        'file_path',
        'file_hash',
        'mime_type',
        'size',
        'extension',
        'attachment_category_id',
        'attachment_type_id',
        'user_id',
        'is_private',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeList($query): void
    {
        // TODO: Implement scopeList() method.
    }
}
