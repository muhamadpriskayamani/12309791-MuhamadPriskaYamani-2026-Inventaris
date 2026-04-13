<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $fillable = ([
        'category_id',
        'name',
        'total',
        'repair',
        'lending',
        'borrowed',
    ]);

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lendingItems()
    {
        return $this->hasMany(LendingItem::class);
    }

    public function getActiveLendingQuantityAttribute()
    {
        return $this->lendingItems()
            ->whereHas('lending', function ($query) {
                $query->where('status', '!=', 'Returned');
            })
            ->sum('total');
    }

    public function getActiveLendingCountAttribute()
    {
        return $this->lendingItems()
            ->whereHas('lending', function ($query) {
                $query->where('status', '!=', 'Returned');
            })
            ->distinct('lending_id')
            ->count('lending_id');
    }

    public function getAvailableAttribute()
    {
        return $this->total - $this->repair - $this->active_lending_quantity;
    }

    public function available()
    {
        return $this->available;
    }
}
