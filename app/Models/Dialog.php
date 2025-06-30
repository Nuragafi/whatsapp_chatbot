<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    protected $table = 'dialogs';
    protected $fillable = [
        'id',
        'message',
        'step',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(Dialog::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Dialog::class, 'parent_id');
    }
}
