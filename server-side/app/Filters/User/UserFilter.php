<?php

namespace App\Filters\User;

use App\Filters\Base\BaseFilter;
use Illuminate\Http\Request;

class UserFilter extends BaseFilter
{
    public bool $verified;

    public function __construct($request=null) {
        parent::__construct($request);

        if( !$request || !is_subclass_of($request, Request::class) ) {
            return;
        }

        if( $request->has('verified') ) {
            $this->setVerified($request->boolean('verified'));
        }
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->verified;
    }

    /**
     * @param bool $verified
     */
    public function setVerified(bool $verified): void
    {
        $this->verified = $verified;
    }

}
