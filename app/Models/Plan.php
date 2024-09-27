<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Plan
 *
 * @mixin Builder
 * @package App
 */
class Plan extends Model
{
    use SoftDeletes;

    protected $casts = [
        'items' => 'object',
        'tax_rates' => 'object',
        'coupons' => 'object',
        'features' => 'object'
    ];

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeOfVisibility(Builder $query, $value)
    {
        return $query->where('visibility', '=', $value);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopePriced(Builder $query)
    {
        return $query->where([['amount_month', '>', 0], ['amount_year', '>', 0]]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeDefault(Builder $query)
    {
        return $query->where([['amount_month', '=', 0], ['amount_year', '=', 0]]);
    }

    /**
     * Get the plan price status
     *
     * @return bool
     */
    public function hasPrice()
    {
        return $this->amount_month || $this->amount_year;
    }
}
