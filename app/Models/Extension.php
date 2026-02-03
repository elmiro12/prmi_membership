<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    protected $table = 'extensions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idMembership', 'created_at','idStreamMembership', 'updated_at'
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'idMembership');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'idExtension');
    }

    public function streamMembership()
    {
        return $this->belongsTo(StreamMembership::class, 'idStreamMembership');
    }


}

