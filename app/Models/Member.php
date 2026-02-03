<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = [
        'fullname', 'dob', 'gender', 'contact_number',
        'address', 'instagram', 'postcode', 'occupation', 'photo', 'idUser'
    ];

    public $timestamps = false;

    public function membership()
    {
        return $this->hasOne(Membership::class, 'idMember');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
    public function streamMemberships()
    {
        return $this->hasOne(StreamMembership::class, 'idMember');
    }
}
