<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $fillable = [
        'start_year', 'end_year'
    ];
    public function classHistories()
    {
        return $this->hasMany(ClassHistory::class);
    }
}
