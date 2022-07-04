<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\LaravelIgnition\Solutions\MakeViewVariableOptionalSolution;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:30',
                'email' => 'required|unique:users|email',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password'
            ]);

            
    

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 442);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('books_app')->plainTextToken;
            DB::commit();

            return response()->json([
                'message' => 'success',
                'access_token' => $token
            ],200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
    } 

    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'email' => 'required|email|exists:users,email',
                'password' => 'required'
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors(),
                ],422);
            }

            if (Auth::attempt(['email' => $request->email,'password' => $request->password],false)){
                $user = User::where('email',$request->email)->firstOrFail();
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'message' => 'success',
                    'token' => $token,
                    'data' => $user,
                ], 201);

            }

            return response()->json([
                "status" => "Failed credential"
            ], 401);

        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return["message" =>'anda telah berhasil logout dan token berhasil dihapus'];
    }
}
