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
"accountNumber" => $dataj->accountno,
"bankName" => $dataj->bankName,
"bvn" => $bvn,

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


     public function store(Request $request)
     {

       $token=JWTAuth::getToken();
       $user=JWTAuth::toUser($token);
  $customerId=$user->customerid;

       $validator=Validator::make($request->all(), [
                 'number' => ['required', 'numeric', 'unique:cards'],
                  'name' => ['required', 'string', 'max:255'],
                  'expiry' => ['required'],
                   'cvv' => ['required','numeric','min:0'],
                   'cardType' => ['required', 'string'],
       ]);
    //   dd($validator->fails());
       if($validator->fails())
       {

         return response()->json([
            'error' => '1',
            'status'  => $validator->messages(),
         ], 400);
       }
       else {
 $dataj= customer::where('customerid','=',$customerId)->first();

if(!is_null($dataj))
{

       $re=cards::create(array(
         "customerid" =>$customerId,
  "name" => $request->get('name'),
  "number" => $request->get('number'),
  "expiry" => $request->get('expiry'),
  "cvv" => $request->get('cvv'),
  "cardType" =>$request->get('cardType')
));
  $data="Card added successful";
         return response()->json([
              'code' => '200',
              'data'  => $data,
           ], 200);

  }
  else
   {
  $data="Something went wrong please try again or contact admin";
  return response()->json([
       'code' => '404',
       'data'  => $data,
    ], 404);
  }

}
     }

     public function showcards(Request $request)
     {
          $token=JWTAuth::getToken();
          $user=JWTAuth::toUser($token);
     $customerId=$user->customerid;
       $dataj= cards::where('customerid','=',$customerId)->get();
//dd($dataj);
if(!is_null($dataj)){
  $date_now = NOW();
  $currentdate =date("m/y",strtotime($date_now));

  // if($currentdate > $dataj[0]['expiry']){
  // $t="Inactive";
  // }
  // else {
  // $t="active";
  // }
foreach ($dataj as $key => $value) {
  if($currentdate > $value->expiry){
  $t="Inactive";
  }
  else {
  $t="active";
  }
  $re=cards::where('id', $value->id)->where('customerid', $customerId)->update([
    "status" =>$t,
]);
}





    return response()->json([
        // 'status' =>$t,
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

     public function createt()
     {
       $validator=Validator::make($request->all(), [
                  'value' => ['required'],
                  'type' => ['required'],
       ]);
       if($validator->fails())
       {

         return response()->json([
           "code"  =>  '400',
       "type"  => "invalid_value",
       "message"  =>  "invalid_credentials",
       "developerMessage"  => $validator->messages(),
         ], 400);
       }
       else {

       $token=JWTAuth::getToken();
       $user=JWTAuth::toUser($token);
     $customerId=$user->customerid;
     $sql = customer::updateOrCreate([ 'transactionPIN' =>Crypt::encrypt($request->value)]);
     $sql2 = User::updateOrCreate([ 'transactionPIN' =>Hash::make($request->value)]);

            }
     }

     public function authupdate(Request $request)
     {
       $token=JWTAuth::getToken();
       $user=JWTAuth::toUser($token);
  $customerId=$user->customerid;
$rowrec = customer::where('customerid','=',$customerId)->first();

if($request->type =="password")
{
  $password=Crypt::decrypt($rowrec->password);
  if($request->old == $password)
  	{
  $sql = customer::where('customerid', $customerId)->update([ 'password' =>Crypt::encrypt($request->new)]);
  $sql2 = User::where('customerid', $customerId)->update([ 'password' =>Hash::make($request->new)]);
//dd($rowrec->password);

    if($sql2)
      {
        $data="Password update successful";
        return response()->json([
             'code' => '200',
             'data'  => $data,
          ], 200);

      }
    else
      {
        $data="Something went wrong password update unsuccessful";
        return response()->json([
             'code' => '404',
             'data'  => $data,
          ], 404);
      }

      }
      else {
        $data="Something went wrong old password incorrect";
        return response()->json([
             'code' => '404',
             'data'  => $data,
          ], 404);

      }
      // code...
}
else{
  $pin=Crypt::decrypt($rowrec->transactionPIN);
    if($request->old == $pin)
  	{
  $sql = customer::where('customerid', $id)->update([ 'transactionPIN' =>Crypt::encrypt($request->new)]);
  $sql2 = User::where('customerid', $id)->update([ 'transactionPIN' =>Hash::make($request->new)]);
    if($sql)
      {
        $data="Transaction pin update successful";
        return response()->json([
             'code' => '200',
             'data'  => $data,
          ], 200);

      }
    else
      {
        $data="Something went wrong transaction pin update unsuccessful";
        return response()->json([
             'code' => '404',
             'data'  => $data,
          ], 404);
      }

      }
      else {
        $data="Something went wrong old transaction pin incorrect";
        return response()->json([
             'code' => '404',
             'data'  => $data,
          ], 404);

      }
      // code...
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
