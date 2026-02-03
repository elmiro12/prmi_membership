<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipType extends Model
{
    protected $table = 'membership_types';

    protected $fillable = ['type', 'amount','merchandise'];

    public $timestamps = false;
    
    protected $casts = [
        'merchandise' => 'array',
    ];

   public function memberships()
    {
        return $this->hasMany(Membership::class, 'tipe_member');
    }

}

