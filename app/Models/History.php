<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'histories';
    protected $fillable = [
        'customer_id',
        'step',
        'dialog_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
