<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\User;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $successStatus = 200;

    public function login()
    {
        $request = request();
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken(Permission::TOKEN_API)->accessToken;
            return response()->json([
                'success' => $success,
                'id' => $user->id,
                'name' => $user->name,
            ],      
            $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function getUser()
    {
        $user = \Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
