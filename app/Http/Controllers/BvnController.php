<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BvnController extends Controller
{
  public function __construct()
   {
       $this->middleware('auth.apikey');
   }


     protected function Bvn(Request $request)
     {

       $validator=Validator::make($request->all(), [
                  'bvn' => ['required','numeric','min:10'],
                  'dob' => ['required'],
       ]);
       if($validator->fails())
       {

         return response()->json([
           "code"  =>  '400',
       "type"  => "invalid_bvn",
       "message"  =>  "invalid_credentials",
       "developerMessage"  => $validator->messages(),
         ], 400);
       }
       else {

          // $data['bvn'] = $request['bvn'];
          //
          // $data['bvnw'] =  Crypt::encrypt($request->bvn);
          // $data['bvne'] =  Crypt::decrypt($data['bvnw']);
   $keys="sk_live_6d1c1f3e7ba648a2254f10ac0d0e003c7edbda70";
       /*
       This PHP script helps to verify a Nigerian bvn number
       using paystack API
       it returns the account name if successful
       curl "https://api.paystack.co/bank/resolve_bvn/USERS_BVN" \
       */
             $dateofbirth =$request->dob;
               $dateofbi=date("Y-m-d",strtotime($dateofbirth));
              $bvn = $request->bvn; //bank CBN code https://bank.codes/api-nigeria-nuban/
              $baseUrl = "https://api.paystack.co";
              $endpoint = "/bank/resolve_bvn/".$bvn."";
              $httpVerb = "GET";
              $contentType = "application/json"; //e.g charset=utf-8
              $authorization =$keys; //gotten from paystack dashboard

              $headers = array (
                  "Content-Type: $contentType",
                  "Authorization: Bearer $authorization"
              );

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_URL, $baseUrl.$endpoint);
          curl_setopt($ch, CURLOPT_HTTPGET, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

          $content = json_decode(curl_exec( $ch ),true);
          $err     = curl_errno( $ch );
          $errmsg  = curl_error( $ch );

          curl_close($ch);
     //dd($content);
          if($content['status'] =="true") {


   if($dateofbi != $content['data']['formatted_dob'])
   {
   $data="date of birth does not match with bvn date of birth formate should be yyyy/mm/dd";

   return response()->json([
      'data' => $data,
    ], 401);
   }else{


     $data['firstName'] = $content['data']['first_name'];
     $data['lastName'] = $content['data']['last_name'];
     $data['dob'] = $content['data']['formatted_dob'];
     $data['email'] =   $request['email'];

   //   $response['mobile'] = $content['data']['mobile'];
   //  $response['bvn'] = $content['data']['bvn'];
   //  $response['calls_this_month'] = $content['meta']['calls_this_month'];
   // $response['free_calls_left'] = $content['meta']['free_calls_left'];

   return response()->json([
      'data' => $data,
     ], 200);
   }



          }
          else
          {

            return response()->json([
              'code' =>'400',
              "type" => "unable_to_resolve",
               'message'=>'Something went wrong trying to verify your BVN.',
               'developerMessage' =>$content['message']
            ], 400);
          }

     }

   }
}
