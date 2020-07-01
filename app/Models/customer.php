<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{

  protected $primaryKey='customerid';

  protected $fillable = [
    'id','customerid', 'address','firstname','accstatus','middleName','wallet_guid','avatar','lastname','email','phone','dob'
];



public function user2()
 {
     return $this->belongsTo( User::class,'customerid','customerid');
 }
}
