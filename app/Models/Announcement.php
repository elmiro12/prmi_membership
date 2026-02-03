<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcement';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'judul', 'deskripsi', 'isi', 'namaFile', 'status', 'created_at', 'updated_at'
    ];
}

