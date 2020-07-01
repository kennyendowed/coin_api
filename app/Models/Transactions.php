<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
  protected $fillable = [
    'id','customerid','type','amount','remarks','to','from'
];
public function user2()
 {
     return $this->belongsTo( User::class,'customerid','customerid');
 }
}
