<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'kode', 'idBank', 'idExtension', 'bukti', 'status', 'created_at'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'idBank');
    }

    public function extension()
    {
        return $this->belongsTo(Extension::class, 'idExtension');
    }
}


