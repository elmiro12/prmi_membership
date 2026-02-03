<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'membership';

    protected $fillable = [
        'idMember', 'membership_number', 'reg_date', 'tipe_member', 'exsist','expiry_date'
    ];

    public $timestamps = false;

    public function member()
    {
        return $this->belongsTo(Member::class, 'idMember');
    }

    public function membershipType()
    {
        return $this->belongsTo(MembershipType::class, 'tipe_member');
    }
    public function extension()
    {
        return $this->hasOne(Extension::class, 'idMembership');
    }

}

