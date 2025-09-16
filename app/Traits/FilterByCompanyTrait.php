<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait FilterByCompanyTrait
{
    /**
     * @param $query
     * @param $filter
     * @return mixed
     */
    public function scopeFilterByCompany($query, $filter = true)
    {
        if (!$filter) {
            return $query;
        }

        $companyId = Auth::user()->company_id;

        return $query->where('company_id', $companyId);
    }

    /**
     * @return mixed
     */
    public static function companyList()
    {
        return static::filterByCompany()
            ->orderBy(static::$title, 'asc')
            ->defaultOrder()
            ->get()
            ->pluck(static::$title, 'id')
            ->toArray();
    }
}
