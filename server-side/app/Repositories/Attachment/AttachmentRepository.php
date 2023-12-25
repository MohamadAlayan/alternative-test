<?php

namespace App\Repositories\Attachment;

use App\Models\Attachment\Attachment;
use App\Repositories\Base\BaseRepository;

class AttachmentRepository extends BaseRepository
{
    public $model = Attachment::class;


    public function getAttachment($name, $hash, $type)
    {
        return $this->model->where('name', $name)
            ->where('attachment_type_id', $type)
            ->where('hash', $hash)
            ->first();
    }


}
