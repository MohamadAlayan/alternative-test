<?php

namespace App\Models\Page;

use App\Models\Base\ListingModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends ListingModel {

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'status',
        'content',
        'parent_id',
    ];

    protected $with = [
        'parent',
    ];


    public function parent(): BelongsTo {
        return $this->belongsTo(Page::class);
    }


    public function scopeList($query): void
    {

    }


}
