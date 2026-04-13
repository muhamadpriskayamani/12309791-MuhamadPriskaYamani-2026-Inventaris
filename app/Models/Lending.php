<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    protected $fillable = [
        'borrower_name',
        'description',
        'date',
        'return_date',
        'status',
        'edited_by'
    ];

    public function items()
    {
        return $this->hasMany(LendingItem::class);
    }
}
