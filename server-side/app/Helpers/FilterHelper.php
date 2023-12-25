<?php

namespace App\Helpers;

use App\Filters\Base\BaseFilter;
use Illuminate\Http\Request;

class FilterHelper
{
    /**
     * @param Request $request
     * @param string $filterModel
     * @return BaseFilter
     */
    public static function getFilter(Request $request, string $filterModel): BaseFilter
    {
        return new $filterModel($request);
    }
}
