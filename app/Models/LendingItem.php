<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LendingItem extends Model
{
    protected $fillable = [
        'lending_id',
        'item_id',
        'total',
        'status'
    ];

    public function lending()
    {
        return $this->belongsTo(Lending::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
