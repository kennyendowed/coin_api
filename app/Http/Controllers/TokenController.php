<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Blockchain;
use Illuminate\Http\Request;

class TokenController extends Controller
{
  public function me()
  {
  return response()->json(auth()->user());
  }

  public function payload()
  {
    $user = auth()->payload();

    return response()->json($user);
  }


  public function refresh()
  {
    return $this->respondWithToken(auth()->refresh());
  //     try{
  // //   $newtoken = $this->respondWithToken(auth()->refresh());
  //        $newtoken = auth()->refresh();
  //     }catch(\Tymon\JWTAuth\Exceptions\TokenInvalideException $e){
  //         return response()->json(['error' => $e->getMessage()],401);
  //     }
  //     return response()->json(['access_token' => $newtoken]);
  }
  protected function respondWithToken($token)
  {


return response()->json([
  'accessToken' => $token,
  'expires' =>  Carbon::now()->addDays(1)->toDateTimeString(),
  'expires_inn' => auth()->factory()->getTTL(),
]);
  }
  public function clearRoute()
      {
           return   \Artisan::call('route:clear');
     //  return    \Artisan::call('optimize');
      }
      public function invalidate()
      {
      return response()->json(auth()->invalidate());
      }

  
}
