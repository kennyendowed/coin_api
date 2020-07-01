<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use DateTime;
use Illuminate\Support\Facades\Crypt;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\customer;
use App\Models\cards;

class CustomerController extends Controller
{
      public function index()
     {
     $data= customer::all();
        return response()->json(compact('data'));
     }



     public function show(Request $request)
     {
          $token=JWTAuth::getToken();
          $user=JWTAuth::toUser($token);
     $customerId=$user->customerid;
    //   dd($request->customerId);
//  $dataj= customer::findOrFail($request->customerId);
//   dd($dataj);
       $dataj= customer::where('customerid','=',$customerId)->first();
//dd($request->customerId);
if(!is_null($dataj)){

  if (!$dataj->bvn) {
    $bvn=$dataj->bvn;
  }
  else {
  //$bn= Crypt::encrypt($dataj->bvn);
    $bvn=Crypt::decrypt($dataj->bvn);
  }

      $data =array(
        "firstName"=> $dataj->firstname,
"lastName" => $dataj->lastname,
"middleName" => $dataj->middleName,
"email" => $dataj->email,
"phoneNumber" => $dataj->phone,
"avatar" => $dataj->avatar,
"customerId" => $dataj->customerid,
"address" => $dataj->address,

// 'password' => Crypt::decrypt($dataj->password),
// "pin" =>Crypt::decrypt($dataj->transactionPIN),
    );
    return response()->json([
         'data'  => $data,
      ], 200);
}else
{
  $data="Something went wrong please try again or contact admin";
  return response()->json([
       'data'  => $data,
    ], 404);
}

     }




     public function update(Request $request)
     {
       $token=JWTAuth::getToken();
       $user=JWTAuth::toUser($token);
  $customerId=$user->customerid;
       $re=customer::where('customerid', $customerId)->update([
         "firstname" =>$request->get('firstName'),
 "lastname" => $request->get('lastName'),
 "middleName" => $request->get('middleName'),
 "email" => $request->get('email'),
 "phone" => $request->get('phoneNumber')
]);

//dd($re);

if($re){
  $data="Customer's profile Updated";
         return response()->json([
              'code' => '200',
              'data'  => $data,
           ], 200);
}
else {
  $data="Something went wrong please try again or contact admin";
  return response()->json([
       'code' => '404',
       'data'  => $data,
    ], 404);
}

     }



     public function imageavatar(Request $request)
{
$request->validate([
'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg||MAX:2084',
]);
  $id=Auth::user()->name;
  $id2=Auth::user()->customerid;

$imageName=$id.'.png';
$newimageName='avatar/'.$imageName;
$se=$request->image->move(public_path('avatar'),$imageName);
$re=User::where('customerid', $id2)->update(['avatar' =>$newimageName]);
//dd($id2);
// $us=User::updateOrCreate([
// 'customerid'=>$id
// ],[
//         //   'user_id' => $user_id,
//         'avatar' =>$imageName
//        ]);
//dd($se);
return back()->with('success','Avatar uploaded')->with('image',$imageName);

}

}
