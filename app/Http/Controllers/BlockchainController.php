<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use DateTime;
use Blockchain;
use Illuminate\Support\Facades\Crypt;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\customer;
use App\Models\Transactions;

class BlockchainController extends Controller
{
    //


         public function sendbitcoin(Request $request)
         {
           $wallet_password="Rooneywwe@11";
           $wallet_guid="4b583f3c-d50c-4d44-b8d2-ef2d241b7bc7";

           $validator=Validator::make($request->all(), [
                      'to' => ['required'],
                      'amount' => ['required'],
           ]);
           if($validator->fails())
           {

             return response()->json([
               "code"  =>  '400',
           "type"  => "invalid_credentials",
           "message"  =>  "invalid_credentials",
           "developerMessage"  => $validator->messages(),
             ], 400);
           }
           else {
    $to_guid=$request['to'];
    $amount=$request['amount'];
           $token=JWTAuth::getToken();
           $user=JWTAuth::toUser($token);

      $customerId=$user->customerid;
      $dataj= customer::where('customerid','=',$customerId)->first();
    $from_guid=$dataj->address;
    $wallet = Blockchain::makeOutgoingPayment($wallet_guid, $amount, $wallet_password, $to_guid,$from_guid);
//dd($wallet);
        if($wallet)
        {
          $re=Transactions::create(array(
            "customerid" =>$customerId,
     "amount" => $amount,
     "to" => $to_guid,
     "from" => $request->get('expiry'),
     "type" =>$wallet['message'],
     'remarks'=>$wallet['tx_hash']
   ));
     $data="Card added successful";
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

         }

         public function getrate()
         {
         $rate=Blockchain::getRates();
             return response()->json($rate);
         }
         public function contobtc(Request $request)
         {

         $rates = Blockchain::convertCurrencyToBTC('NGN' , 600000);
         //$rates =  Blockchain::getStats();
         //  $rates = Blockchain::convertCurrencyToBTC($request->value,$request->amount);
           return response()->json($wallet);
         }
}
