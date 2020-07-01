<?php

namespace App\Http\Controllers;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use URL;
use Blockchain;
use DateTime;
use App\Models\wallets;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Mail;
use App\Models\customer;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\User;
use Carbon\Carbon;
// use App\Http\Resources\RegisterResource;

class AuthController extends Controller
{

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  //protected $redirectTo = '/dashboard';

  public function redirectTo()
  {
    $role = Auth::user()->is_permission;
    switch($role)
    {
      case 1:
        return '/dashboard';
        break;
      case 2:
        return '/dboard';
        break;
        case 3:
          return '/home';
          break;
      default:
        return '/';
        break;
    }
  }

  /**
   * Create a new controller instance.
   *
   * @return void
   */
   protected $username;

   /**
    * Create a new controller instance.
    */
   public function __construct()
   {
       $this->middleware('guest')->except('logout');
       $this->username = $this->findUsername();
   }

   /**
    * Get the login username to be used by the controller.
    *
    * @return string
    */
   public function findUsername()
   {
       $login = request()->input('email');

       $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

       request()->merge([$fieldType => $login]);

       return $fieldType;
   }

   /**
    * Get username property.
    *
    * @return string
    */
   public function username()
   {
       return $this->username;
   }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
      return Validator::make($data, [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
      ]);
  }


//   protected function Bvn(Request $request)
//   {
//
//     $validator=Validator::make($request->all(), [
//                'bvn' => ['required','numeric','min:10'],
//                'dob' => ['required'],
//     ]);
//     if($validator->fails())
//     {
//
//       return response()->json([
//         "code"  =>  '400',
//     "type"  => "invalid_bvn",
//     "message"  =>  "invalid_credentials",
//     "developerMessage"  => $validator->messages(),
//       ], 400);
//     }
//     else {
//
//        // $data['bvn'] = $request['bvn'];
//        //
//        // $data['bvnw'] =  Crypt::encrypt($request->bvn);
//        // $data['bvne'] =  Crypt::decrypt($data['bvnw']);
// $keys="sk_live_6d1c1f3e7ba648a2254f10ac0d0e003c7edbda70";
//     /*
//     This PHP script helps to verify a Nigerian bvn number
//     using paystack API
//     it returns the account name if successful
//     curl "https://api.paystack.co/bank/resolve_bvn/USERS_BVN" \
//     */
//           $dateofbirth =$request->dob;
//             $dateofbi=date("Y-m-d",strtotime($dateofbirth));
//            $bvn = $request->bvn; //bank CBN code https://bank.codes/api-nigeria-nuban/
//            $baseUrl = "https://api.paystack.co";
//            $endpoint = "/bank/resolve_bvn/".$bvn."";
//            $httpVerb = "GET";
//            $contentType = "application/json"; //e.g charset=utf-8
//            $authorization =$keys; //gotten from paystack dashboard
//
//            $headers = array (
//                "Content-Type: $contentType",
//                "Authorization: Bearer $authorization"
//            );
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_URL, $baseUrl.$endpoint);
//        curl_setopt($ch, CURLOPT_HTTPGET, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        $content = json_decode(curl_exec( $ch ),true);
//        $err     = curl_errno( $ch );
//        $errmsg  = curl_error( $ch );
//
//        curl_close($ch);
//   //dd($content);
//        if($content['status'] =="true") {
//
//
// if($dateofbi != $content['data']['formatted_dob'])
// {
// $data="date of birth does not match with bvn date of birth formate should be yyyy/mm/dd";
//
// return response()->json([
//    'data' => $data,
//  ], 401);
// }else{
//
//
//   $data['firstName'] = $content['data']['first_name'];
//   $data['lastName'] = $content['data']['last_name'];
//   $data['dob'] = $content['data']['formatted_dob'];
//   $data['email'] =   $request['email'];
//
// //   $response['mobile'] = $content['data']['mobile'];
// //  $response['bvn'] = $content['data']['bvn'];
// //  $response['calls_this_month'] = $content['meta']['calls_this_month'];
// // $response['free_calls_left'] = $content['meta']['free_calls_left'];
//
// return response()->json([
//    'data' => $data,
//   ], 200);
// }
//
//
//
//        }
//        else
//        {
//
//          return response()->json([
//            'code' =>'400',
//            "type" => "unable_to_resolve",
//             'message'=>'Something went wrong trying to verify your BVN.',
//             'developerMessage' =>$content['message']
//          ], 400);
//        }
//
//   }
//
// }



    /**
     * Register a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

public function signUp(Request $request)
{
  $validator=Validator::make($request->all(), [
             'firstName' => ['required', 'string', 'max:40'],
             'lastName' => ['required', 'string', 'max:40'],
             'phoneNumber' =>['required','regex:/^([0-9\s\-\+\(\)]*)$/','min:10'],
             'dob' => ['required','date_format:Y-m-d','before:today'],
          // 'username' => ['required', 'string', 'unique:users', 'alpha_dash'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:8'],
  ]);
  if($validator->fails())
  {

    return response()->json([
      "code"  =>  '400',
  "type"  => "invalid_firstName",
  "message"  =>  "invalid_credentials",
  "developerMessage"  => $validator->messages(),
    ], 400);
  }
  else {
    $rand=rand(100,9999);
$label=$request['firstName'].''.$request['lastName'];
$wallet_password="Rooneywwe@11";
$wallet_guid="4b583f3c-d50c-4d44-b8d2-ef2d241b7bc7";

//     $wallet = Blockchain::createWallet($request['password'] , $request['firstName'] ,$request['email']);
// $wallet_guid=$wallet['guid'];
// $acc=$wallet['address'];
$wallet=Blockchain::createNewAddress($wallet_guid, $wallet_password, $label);
//dd($wallet);
$acc=$wallet['address'];
   if($wallet) {

    $user=User::create([
            'customerid' =>$rand,
               'email' => $request['email'],
               'name' => $request['firstName'].' '.$request['lastName'],
                'ip_address' =>  request()->ip(),
               'password' => Hash::make($request['password']),
               'is_permission'  => 3

           ]);

           if($user->exists)
           {
          $wallet_guid=$label;

             $customer =  customer::create(array(
             'customerid' =>$rand,
              'address' => $acc,
              'dob' => $request->get('bob'),
               'firstname' => $request->get('firstName'),
               'lastname' =>$request->get('lastName') ,
               'email'  => $request->get('email'),
               'phone'  => $request->get('phoneNumber'),
                'accstatus'    =>'InActive',
                'wallet_guid'  => $wallet_guid,
                  ));   // $sq3=cards::create(array(
                       //         'customerid' =>$rand,
                       //          'name' => 'null',
                       //           'number' => 0,
                       //            'expiry' =>0,
                       //            'cvv' =>0,
                       //            'cardType' =>0
                       //      ));
           }

           $subj='Welcome To Trade with mark Austine';
         $mess='We welcome you to Trade with mark Austine platform as we hope to serve you better.
         Your login Id is '.$request->username.', your account password is '.$request->password.'
          . Plesae feel free to change it any time';
         $contactSubject = 'Feedback!';
         $img2 =public_path().'/assets/images/login-image.jpg';
           $data = array(
                 'no-reply' => 'no-reply@TradewithmarkAustine.com',
                   'admin'    => 'kenneyg50@gmail.com',
                   'address' =>$acc,
                   'firstName'=>$request->firstName,
                   'lastName'=>$request->lastName,
                   'name'=>$request->firstName.''.$request->lastName,
                   'email'=>$request->email,
                   'messagetext'=>$mess,
                   'app_name' => config('app.name'),
                   'contactSubject'=>$contactSubject,
                   'img' => $img2,
                   'gin'=>$rand,
                   'password' =>$request->password,
                 'message' => "mail sent"
               );
         //             Mail::send(array(), array(), function ($message) use ($html) {
         //   $message->to(..)
         //     ->subject(..)
         //     ->from(..)
         //     ->setBody($html, 'text/html');
         // });
         Mail::send(array(), $data, function ($message) use ($data){
           $img2 =public_path().'/assets/images/login-image.jpg';
           $html='
         <html>
         <head>
         <meta name="viewport" content="width=device-width" />
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
         <title>New Account information!</title>
         <style>
         /* -------------------------------------
             GLOBAL RESETS
         ------------------------------------- */

         /*All the styling goes here*/

         img {
           border: none;
           -ms-interpolation-mode: bicubic;
           max-width: 100%;
         }
         body {
           background-color: #f6f6f6;
           font-family: sans-serif;
           -webkit-font-smoothing: antialiased;
           font-size: 14px;
           line-height: 1.4;
           margin: 0;
           padding: 0;
           -ms-text-size-adjust: 100%;
           -webkit-text-size-adjust: 100%;
         }
         table {
           border-collapse: separate;
           mso-table-lspace: 0pt;
           mso-table-rspace: 0pt;
           width: 100%; }
           table td {
             font-family: sans-serif;
             font-size: 14px;
             vertical-align: top;
         }
         /* -------------------------------------
             BODY & CONTAINER
         ------------------------------------- */

         .content-block {
           padding-bottom: 10px;
           padding-top: 10px;
         }
         .footer {
           clear: both;
           margin-top: 10px;
           text-align: center;
           width: 100%;
         }
           .footer td,
           .footer p,
           .footer span,
           .footer a {
             color: #999999;
             font-size: 12px;
             text-align: center;
         }
         /* -------------------------------------
             TYPOGRAPHY
         ------------------------------------- */

         /* -------------------------------------
             RESPONSIVE AND MOBILE FRIENDLY STYLES
         ------------------------------------- */
         @media only screen and (max-width: 620px) {
           table[class=body] h1 {
             font-size: 28px !important;
             margin-bottom: 10px !important;
           }
           table[class=body] p,
           table[class=body] ul,
           table[class=body] ol,
           table[class=body] td,
           table[class=body] span,
           table[class=body] a {
             font-size: 16px !important;
           }
           table[class=body] .wrapper,
           table[class=body] .article {
             padding: 10px !important;
           }
           table[class=body] .content {
             padding: 0 !important;
           }
           table[class=body] .container {
             padding: 0 !important;
             width: 100% !important;
           }
           table[class=body] .main {
             border-left-width: 0 !important;
             border-radius: 0 !important;
             border-right-width: 0 !important;
           }
           table[class=body] .btn table {
             width: 100% !important;
           }
           table[class=body] .btn a {
             width: 100% !important;
           }
           table[class=body] .img-responsive {
             height: auto !important;
             max-width: 100% !important;
             width: auto !important;
           }
         }
         /* -------------------------------------
             PRESERVE THESE STYLES IN THE HEAD
         ------------------------------------- */

         </style>
         </head>
         <body class="">

         <div class="container" text-align="center">
         <h3 class="panel-title navbar-brand">New Account information!</h3>

         <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
         <td align="center">



         <b style="font-size: 20px"></b>
           <!-- info row -->
           <div class="row">
             <div class="col-md-8">

         <img style="width:80px; height: auto;" src="'.$message->embed($img2).'" alt="New Account information!" class="logo-text-light"/>
               <p>Hi '.$data['firstName'].' '.$data['lastName'].',  </p>
               <p> Welcome you to our online banking platform as we hope to serve you better. </p>
                 <p>E-Mail is                 '.$data['email'].',</p>
              <p>Account password is        '.$data['password'].', </p>
               <p>Address is  '.$data['address'].', </p>
               <p>  Please click on the link to verify your email account.        </p>

         <br />
         <a href="'.url("Authorization",$data['gin']).'">Verify E-Mail</a>

                <!-- <p>Look out for more information on celebrityfc.ng and on Instagram at @celebrityfanschallenge</p>
                 <p>If you have any question leading up to the event, you can send us mail at celebrityfcng@gmail.com.</p> -->
                 <p>Plesae feel free to change it any time!</p>
                 <p>Regards</p>
                 <p>'.$data['app_name'].'!! </p>
              </br>


             </div><!-- /.col -->

           </div><!-- /.row -->
           </td>
         </tr>
         </table>
         <!-- START FOOTER -->
         <div class="footer">
         <table role="presentation" border="0" cellpadding="0" cellspacing="0">
         <tr>
         <td class="content-block">
           <img src="'.$message->embed($img2).'" alt="'.$data['app_name'].'" class="logo-text-light"/>
           <span class="apple-link">© 2020 '.config('app.name').' !. All rights reserved.</span>
          <!--  <br> Dont like these emails? <a href="http://i.imgur.com/CScmqnj.gif">Unsubscribe</a>. -->
         </td>
         </tr>
         <tr>
         <td class="content-block powered-by">
           Powered by <a href="http://TradewithmarkAustine.com">TradewithmarkAustine.com</a>.
         </td>
         </tr>
         </table>
         </div>
         <!-- END FOOTER -->
         </body>
         </html>


         ';


                  $to_email =$data['email'];
                  $to_name  = $data['firstName'].''.$data['lastName'];
                  $subject  = $data['contactSubject'];
                  $message->sender($data['no-reply'], $data['app_name'].' New Account information!');
                  $message->replyTo($data['no-reply'], ' Web Administrator');
                    $message->from($data['no-reply'],$data['app_name'].' New Account information!');
                  $message->subject('Feedback!');
                   $message->bcc("kennygendowed@gmail.com");
             // $message->bcc("clipsemgt@gmail.com");
                     $message->to($to_email, $to_name);
                     $message->setBody($html, 'text/html');
                });
         $cp=count(Mail::failures());

                 }
               }
         $token = auth()->login($user);

         if (!$token) {
                $token =array(
               'success' => false,
               'message' => 'Invalid Parameters',
               'status' => '401'
           );
         return response()->json(compact('token'));
         }
         else {
           $data='Created Successfully';
         return $this->loginWithToken($token,$data);
         }







}



    /**
     * Get a JWT via given credentials.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
      $validator=Validator::make($request->all(), [
                'userName' => 'required', 'string', 'email', 'max:255',
                 'password' => ['required', 'string', 'max:255'],
      ]);
      if($validator->fails())
      {

        return response()->json([
           'error' => '1',
           'status'  => $validator->messages(),
        ], 200);
      }
      else {

      $login = request()->input('userName');

      $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'userName';

      request()->merge([$fieldType => $login]);

    //  return $fieldType;

        $credentials = $request->only([$fieldType, 'password']);

        if (!$token = auth()->claims(['expires' =>  Carbon::now()->addDays(1)->toDateTimeString()])->attempt($credentials)) {
                 $token =array(
              "code" => '401',
               "type" => "invalid_credentials",
               "message" => "We were unable to validate your credentials, please check your credentials and try again",
               "developerMessage" => $token
            );
          return response()->json(compact('token'));
        }

        return $this->respondWithToken($token);
      }
    }



    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
//$account_details=$this->Useraccountinfo(auth()->user()->customerid);
      //  $user=$this->getUser($token);
        // $data =array(
        //   // 'customer_id'   =>  auth()->user()->customerid,
        //     'accessToken' => $token,
        //      //  'expires' => auth()->factory()->getTTL() * 1440, // can change to 5 or 10 mins
        //      // 'expires_in' => Carbon::parse(auth()->factory()->getTTL() * 1400)->toDateTimeString(),
        //      'expires' =>  Carbon::now()->addDays(1)->toDateTimeString(),
        //      'expires_inn' => auth()->factory()->getTTL(),
        //      // 'expiresv' => Carbon::now()->addDays(1)->toDateTimeString(),
        //      // 'now' =>  Carbon::parse(auth()->factory()->getTTL() * 60)->toDateTimeString()
        //     // 'token_type' => 'bearer',
        //     // 'success' => true,
        //     //  'message' => 'Login was  successfully Please A mail containing your account login details has been sent to you Check Email To Activate Account And For Login Details',
        //     // 'status' => '200',
        //     //   'user_id'   => auth()->user()->id
        //
        // );
      //  return response()->json(compact('data'));

      $user=array();
        $user = auth()->payload();
        $u=$user['exp'];
        $dt=new DateTime("@$u");
return response()->json([
    'accessToken' => $token,
    'expires' => $dt->format('Y-m-d H:i:s'),

    // 'expires' => auth()->factory()->getTTL(),
]);
    }




    protected function loginWithToken($token,$message)
    {
      $user=array();
        $user = auth()->payload();
        $u=$user['exp'];
        $dt=new DateTime("@$u");
  //$account_details=$this->Useraccountinfo(auth()->user()->customerid);
      //  $user=$this->getUser($token);
        $data =array(
          // 'customer_id'   =>  auth()->user()->customerid,
            'accessToken' => $token,
            'expires' => $dt->format('Y-m-d H:i:s')
          //    'expires' => auth()->factory()->getTTL() * 1400 // can change to 5 or 10 mins

        );
        return response()->json(compact('data','message'));
    }
 /**
     * Get the user by token.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($request)
    {
        JWTAuth::setToken($request);
        $user = JWTAuth::toUser();
        return response()->json($user);
    }

    public function Authorization(Request $request)
    {
        $datetime=date("Y-m-d h:i:s");
      $dat2 =User::where('customerid', $request->id)->get();
  //  dd($dat2);
      if(count($dat2) > 0)
      {
          DB::table('users')->where('customerid', $request->id)->update([

           'email_verified_at' =>$datetime
           ]);

           $data=$dat2[0]->name." Account your validated";

        return response()->json([
             'code' => '200',
             'status'  => $data,
          ], 200);
      }
      else {

        $data="Something went wrong please try again or contact admin";
        return response()->json([
             'data'  => $data,
          ], 404);
      }
    }



    public function Useraccountinfo($request)
    {
      $data['user_usdaccounts_info'] = DB::table('usdaccounts')->where('customerid', $request)->get();
      $data['user_account_info'] = DB::table('accounts')->where('customerid', $request)->get();
        $data['user_customer_info'] = DB::table('customers')->where('customerid', $request)->get();
      return response()->json($data);
    }

    public function logout()
  {
  //try {
  auth()->logout();

      return response()->json([
         'data' =>'200',
         'message' =>'Successfully logged out'
      ], 200);

  // } catch (JWTException $e) {
  //     if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
  //         return response()->json(['status' => 'Token is Invalid']);
  //     }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
  //       // $refreshed = JWTAuth::refresh(JWTAuth::getToken());
  //       // $user = JWTAuth::setToken($refreshed)->toUser();
  //   //    header('Authorization: Bearer ' . $refreshed);
  //         return response()->json(['status' => 'Token is Expired']);
  //     }else{
  //         return response()->json(['status' => 'Authorization Token not found']);
  //     }
  // }



  }

  public function getAuthenticatedUser()
          {
                  try {

                          if (! $user = JWTAuth::parseToken()->authenticate()) {
                                  return response()->json(['user_not_found'], 404);
                          }

                  } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                          return response()->json(['token_expired'], $e->getStatusCode());

                  } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                          return response()->json(['token_invalid'], $e->getStatusCode());

                  } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                          return response()->json(['token_absent'], $e->getStatusCode());

                  }

                  return response()->json(compact('user'));
          }



}
