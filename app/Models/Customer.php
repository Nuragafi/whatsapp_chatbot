<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'phone_number',
    ];

    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
