<?php

namespace App\Http\Controllers;
use JWTAuth;
use App\User;
use App\Models\Transactions;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
  public function index(Request $request)
  {
       $token=JWTAuth::getToken();
       $user=JWTAuth::toUser($token);
      // dd(payload($token));
  $customerId=$user->customerid;
 //   dd($request->customerId);
//  $dataj= customer::findOrFail($request->customerId);
//   dd($dataj);
    $dataj= Transactions::where('customerid','=',$customerId)->orderBy('id','desc')->take(10)->get();
//dd($request->customerId);
if(!is_null($dataj)){

 return response()->json([
      'data'  => $dataj,
   ], 200);
}else
{
$data="Something went wrong please try again or contact admin";
return response()->json([
    'data'  => $data,
 ], 404);
}

  }


}
