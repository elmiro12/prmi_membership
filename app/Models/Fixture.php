<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_club_home',
        'id_club_away',
        'match_date',
        'match_time',
        'venue',
        'embed_url',
    ];

    public function homeClub() {
        return $this->belongsTo(Club::class, 'id_club_home');
    }

    public function awayClub() {
        return $this->belongsTo(Club::class, 'id_club_away');
    }
}
