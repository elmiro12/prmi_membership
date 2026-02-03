<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamMembership extends Model
{
    protected $table = 'stream_membership';

    protected $fillable = [
        'kode','idMember', 'idType'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'idMember');
    }

    public function streamType()
    {
        return $this->belongsTo(StreamType::class, 'idType');
    }

    public function extension()
    {
        return $this->hasOne(Extension::class, 'idStreamMembership');
    }
}
