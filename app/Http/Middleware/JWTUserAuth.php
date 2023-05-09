<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;
use App\Models\B2CService\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTUserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            JWTAuth::setToken($request->header('Authorization'));
            $user = json_decode(JWTAuth::getPayload(JWTAuth::getToken()));
            $userObj = User::find($user->sub);
            if ($userObj == null || $userObj->status == 0) {
                return response()->json(['status' => 'error', 'data' => '', 'message' => 'Your account is blocked.'], 400);
            }
            $request->setUserResolver(function () use ($userObj) {
                    return $userObj;
                });
            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'data' => '', 'message' => 'token_expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'data' => '', 'message' => 'token_invalid'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'data' => '', 'message' => $e->getMessage()], 401);
        }
    }
}
