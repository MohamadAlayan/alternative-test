<?php

namespace App\Models\Base;

use Carbon\Carbon;
use App\Filters\Base\BaseFilter;

abstract class ListingModel extends BaseModel
{
    public static array $hideInList = [];



    // Function to convert class of given object
    public function castObjectTo($object, $final_class) {
        if( empty($object) ) {
            return new $final_class();
        }

        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($final_class),
            $final_class,
            strstr(strstr(serialize($object), '"'), ':')
        ));
    }

    /**
     * Sorts the results according to $sort and direction according to $descending
     * @param $query
     * @param $sortBy
     * @param bool $descending
     */
    public function scopeSort($query, $sortBy = null, bool $descending = false): void
    {
        $query->when($sortBy, function ($query) use ($sortBy, $descending) {
            $order = "asc";
            if ($descending === true) {
                $order = "desc";
            }
            $query->orderBy($sortBy, $order);
        }, function ($query) {
            $query->latest();
        });
    }

    /**
     * Filters the results according to the given filter value
     * @param $query
     * @param BaseFilter|null $filter
     * @return void
     */
    public function scopeFilter($query, BaseFilter $filter = null) {

    }


    /**
     * Used to add methods to the model for listing data
     * @param $query
     *
     * @return void
     */
    abstract public function scopeList($query): void;


    public function scopeByDate($query, $date): void
    {}
}

