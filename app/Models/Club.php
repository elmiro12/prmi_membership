<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
   protected $fillable = ['name', 'logo', 'is_primary'];

    public function matches()
    {
        return $this->hasMany(Fixture::class);
    }
}
