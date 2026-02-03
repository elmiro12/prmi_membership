<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    protected $table = 'verify';
    protected $primaryKey = 'id';

    protected $fillable = ['idUser', 'token', 'verify','resend_count','last_resend_at'];
    public $timestamps = false;
    
    protected $casts = [
        'last_resend_at' => 'datetime',
    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'idUser');
    }
}

