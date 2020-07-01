<?php

namespace App\Http\Controllers;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;
    use App\Models\wallets;


class WalletsController extends Controller
{
  public function index()
 {
 $data= wallets::all();
    return response()->json(compact('data'));
 }

 public function show(Request $request)
 {
   $token=JWTAuth::getToken();
   $user=JWTAuth::toUser($token);
 $customerId=$user->customerid;

   $dataj= wallets::where('customerid','=',$customerId)->where('type','=',$request->type)->get();
   if($dataj[0]->type =='loan')
   {
     $data =array(
       'customer_id'   =>  $dataj[0]->customerid,
         'type' =>  $dataj[0]->type,
           'balance' =>  $dataj[0]->balance
     );
       return response()->json(compact('data'));
   }
   else {
     $data =array(
       'customer_id'   =>  $dataj[0]->customerid,
         'type' =>  $dataj[0]->type,
           'balance' =>  $dataj[0]->balance,
           'inflow'  =>$dataj[0]->inflow,
           'outflow' =>$dataj[0]->outflow
     );
       return response()->json(compact('data'));
   }

  //   return $request->type;
 }

 public function store(Request $request)
 {
     $article = Article::create($request->all());

     return response()->json($article, 201);
 }

 public function update(Request $request, Article $article)
 {
     $article->update($request->all());

     return response()->json($article, 200);
 }

 public function delete(Article $article)
 {
     $article->delete();

     return response()->json(null, 204);
 }
}
