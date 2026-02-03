<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamType extends Model
{
    protected $table = 'stream_type';

    protected $fillable = [
        'name','amount'
    ];

    public function streamMemberships()
    {
        return $this->hasMany(StreamMembership::class, 'idType');
    }
}
