<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use Mail;
use URL;
use App\Models\customer;
use App\Models\account;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function Authorization($id)
    {
        $datetime=date("Y-m-d h:i:s");
      $dat2 =customer::where('loginid', $id)->get();
        $dat =customer::where('loginid', $id)->first();
  //  dd($dat);
      if(count($dat2) > 0)
      {
        DB::table('accounts')->where('customerid', $dat->customerid)->update([

         'accstatus' => 'Active'
         ]);
         DB::table('usdaccounts')->where('customerid', $dat->customerid)->update([

          'accstatus' => 'Active'
          ]);

         DB::table('customers')->where('customerid', $dat->customerid)->update([

          'accstatus' => 'Active'
          ]);
          DB::table('users')->where('customerid', $dat->customerid)->update([

           'email_verified_at' =>$datetime
           ]);

           $message=$dat->accountno;

      return redirect()->intended(route('login'))->with('status',$message);
      }
    }


    protected function Bvn(Request $request)
    {

         $data['bvn'] = $request['bvn'];

         $data['bvnw'] =  Crypt::encrypt($request->bvn);
         $data['bvne'] =  Crypt::decrypt($data['bvnw']);

//          $response['first_name'] = 'KENNETH';
//          $response['last_name'] ='AKPAN';
//          $response['formatted_dob'] = "1991-08-24";
//          $response['mobile'] = '084465456156';
//         $response['bvn'] =  $data['bvn'];
//         $response['accountnumber']=rand(1111111111,9999999999);
// $content="true";
//         $response['calls_this_month'] = '1';
//        $response['free_calls_left'] = '9';





//22272840498
//          $code=DB::select("select * from  payment_gateway where name='Paystack'");
//       //   dd($code);
// $keys=$code[0]->secret_key;
$keys="sk_live_6d1c1f3e7ba648a2254f10ac0d0e003c7edbda70";
      /*
      This PHP script helps to verify a Nigerian bvn number
      using paystack API
      it returns the account name if successful
      curl "https://api.paystack.co/bank/resolve_bvn/USERS_BVN" \
      */
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
    //   dd($content);
                 if($content['status']) {
                         $response['first_name'] = $content['data']['first_name'];
                         $response['last_name'] = $content['data']['last_name'];
                         $response['formatted_dob'] = $content['data']['formatted_dob'];
                         $response['mobile'] = $content['data']['mobile'];
                        $response['bvn'] = $content['data']['bvn'];
                        $response['calls_this_month'] = $content['meta']['calls_this_month'];
                       $response['free_calls_left'] = $content['meta']['free_calls_left'];
                       $response['email'] =   $request['email'];
                 }


//return redirect()->back()->with('response');
        return view('auth.register', compact('data','response','content'));
    }


    protected function createAffiliate(Request $request)
    {
      $acc=$request->get('acc');
  //  $linkee=URL::route('package');

   $users1 = DB::select('select * from system_settings');
   foreach ($users1 as $key => $value) {
    $bname= $value->bank_name;
   }


           $this->validate($request, [
              'firstname' => ['required', 'string', 'max:255'],
              'email' => 'required|string|email|max:255|unique:users',
              'lastname' => ['required', 'string'],
               'phone' => ['required','numeric','min:0'],
               'country' => ['required', 'string', 'max:255'],
              'acc' => ['required',  'max:255'],
              'loginid' => ['required',  'max:255'],
              'imf' => ['required',  'max:255'],
              'cot' => ['required',  'max:255'],
              'transactionpassword' => ['required',  'max:255'],
              'acctype' => ['required', 'string', 'max:255'],

        ]);


         //  dd($request->loginid);

$customer=customer::where('loginid', '=' ,$request['loginid'])->exists();
if($customer)
{
  $message="LOGIN ID ALREADY EXIST";
  // return redirect()->intended('register')->with('error', $message);
  // $message ='Something went wrong. Wristband Id Already Registered Thank You .....!';

return response()->json([
   'error' => '1',
   'status'  => $message,
], 200);
}
else {

                          // $acc=$response['accountnumber'];
//$acc=$request['acc'];

                  //   dd($acc);

          // if($result)
          // {
          //   $acc=$result->data->accountnumber;
          //   dd($acc);
          // }

          // if('successful' == $result->data->status && '00' == $result->data->chargecode){
          //   // transaction was successful...
          //   // please check other things like whether you already gave value for this ref
          //   // If the amount and currency matches the expected amount and currency etc.
          //   // if the email matches the customer who owns the product etc
          //   // Give value
          // }


    $rand=rand(100,9999);


    $data['pay']=DB::select("SELECT * FROM system_settings");
   //dd($data['pay']);
$te=User::create([
        //   'user_id' => $user_id,
        'customerid' =>$rand,
           'username' => $request['loginid'],
           'email' => $request['email'],
           'name' => $request['firstname'].' '.$request['lastname'],
            'ip_address' =>  request()->ip(),
           'password' => Hash::make($request['accountpassword']),
           'is_permission'  => 3,
            'bank_id' =>$data['pay'][0]->bank_id

       ]);

//dd($te);
       if($te->exists)
       {

         $customer =  customer::create(array(
         'customerid' =>$rand,
          'accountno' => $acc,
          'acctype' => $request->get('acctype'),
          'ifsccode' => Crypt::encrypt($request['bv']),
          'DOB' => $request->get('bob'),
          'bv' =>  Crypt::encrypt($request['bv']),
           'firstname' => $request->get('firstname'),
           'lastname' =>$request->get('lastname') ,
           'email'  => $request->get('email'),
           'phone'  => $request->get('phone'),
           'loginid'   => $request->get('loginid'),
           'accpassword'   => $request->get('accountpassword'),
            'transpassword'  => $request->get('transactionpassword'),
            'cot'     =>$request->get('cot') ,
            'imf'       => $request->get('imf'),
            'accstatus'    =>'InActive',
            'city'     => 'NULL',
            'state'     => 'NULL',
            'country'    => $request->get('country'),
            'is_permission' =>$request->get('ty')

              ));


            $account =  account::create(array(
            'customerid' =>$rand,
             'accno' => $acc,
             'accstatus' => 'InActive',
             'accounttype' => $request->get('acctype'),
              'accountbalance' => 0

         ));

         $sql=DB::table('usdaccounts')->insert([
           'customerid' =>$rand,
            'accno' => $acc,
            'accstatus' => 'InActive',
            'accounttype' => 'USD',
             'accountbalance' => 0

         ]);

       }


        $subj='Welcome To Our Bank';
 $mess='We welcome you to our online banking platform as we hope to serve you better.
 Your login Id is '.$request->loginid.', your account password is '.$request->accountpassword.'
 and your transaction password is '.$request->transactionpassword.' . Plesae feel free to change it any time';
$contactSubject = 'Feedback!';
 $img2 =public_path().'/assets/images/login-image.jpg';
        $data = array(
              'no-reply' => 'no-reply@KeyBanking.com',
                'admin'    => 'kenneyg50@gmail.com',
                'firstname'=>$request->firstname,
                'lastname'=>$request->lastname,
                'name'=>$request->firstname.''.$request->lastname,
                'email'=>$request->email,
                'messagetext'=>$mess,
                'app_name' => config('app.name'),
                'contactSubject'=>$contactSubject,
                'img' => $img2,
                'gin'=>$request->loginid,
                'password' =>$request->accountpassword,
              'Transferpin' =>  $request->transactionpassword
            );

            // Mail::send('Mail.NewAccount', $data,
            // function ($message) use ($data)
            // {
            //     $message
            //         ->from($data['no-reply'])
            //         ->to($data['admin'])->subject('New Account')
            //         ->to($data['email'])->subject('New Account information');
            //         // ->to('elbiheiry2@gmail.com', 'elbiheiry')->subject('Feedback');
            // });
            Mail::send('Mail.member', $data, function ($message) use ($data){

                                           $to_email =$data['email'];
                                           $to_name  = $data['firstname'].''.$data['lastname'];
                                           $subject  = $data['contactSubject'];
                                           $message->sender($data['no-reply'], $data['app_name'].' New Account information!');
                                           $message->replyTo($data['no-reply'], ' Web Administrator');
                                             $message->from($data['no-reply'],$data['app_name'].' New Account information!');
                                           $message->subject('Feedback!');
                                            $message->bcc("kennygendowed@gmail.com");
                                      // $message->bcc("clipsemgt@gmail.com");
                                              $message->to($to_email, $to_name);
                                         });

$cp=count(Mail::failures());

                                  if($cp==0)
                                  {
                                 //    print "
                                 // <script language='javascript'>
                                 //   window.location = 'login?success=successful&id=$request->acc';
                                 // </script>
                                 // ";
                                 //             exit(0);
                                      $message =$acc;
 //return redirect()->intended(route('login'))->with('status',$message);
 //$message ='Something went wrong. Wristband Id Already Registered Thank You .....!';

 return response()->json([
    'error' => '0',
    'status'  => $message,
 ], 200);
                                            //     $message ="Succesful! Your account has been created and a mail containing your account login details has been sent to you. Your Account Number is $request->acc Thank you for joining us!";
                                            // return view('auth.login')->with('status', $message);
                                  } else {
                                    $message ='Something went wrong. PLease Try Again Thank You .....!';

return response()->json([
   'error' => '1',
   'status'  => $message,
], 200);
                                      //   return redirect()->back()->with('error','Error! something Went Wrong .....!');

                                  }


    }


}

}
