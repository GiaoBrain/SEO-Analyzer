<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Cronjob extends Model
{
    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }
}
