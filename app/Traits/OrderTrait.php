<?php
namespace App\Traits;

trait OrderTrait
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeDefaultOrder($query)
    {
        foreach ($this->order as $field => $direction) {
            $query = $query->orderBy($field, $direction);
        }

        return $query;
    }
}