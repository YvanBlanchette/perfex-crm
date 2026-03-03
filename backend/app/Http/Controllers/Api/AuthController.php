<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller {
    public function login(Request $request) {
        $request->validate(['email'=>'required|email','password'=>'required']);
        $user = User::where('email',$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password))
            throw ValidationException::withMessages(['email'=>['Invalid credentials.']]);
        if(!$user->is_active) throw ValidationException::withMessages(['email'=>['Account is inactive.']]);
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['token'=>$token,'user'=>$user]);
    }
    public function register(Request $request) {
        $data = $request->validate(['name'=>'required|string','email'=>'required|email|unique:users','password'=>'required|min:8|confirmed']);
        $user = User::create(['name'=>$data['name'],'email'=>$data['email'],'password'=>$data['password'],'role'=>'staff']);
        return response()->json(['token'=>$user->createToken('api-token')->plainTextToken,'user'=>$user],201);
    }
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out.']);
    }
    public function me(Request $request) { return response()->json($request->user()); }
    public function updateProfile(Request $request) {
        $data = $request->validate(['name'=>'required|string','email'=>'required|email|unique:users,email,'.$request->user()->id,'phone'=>'nullable|string']);
        $request->user()->update($data);
        return response()->json($request->user()->fresh());
    }
    public function updatePassword(Request $request) {
        $request->validate(['current_password'=>'required','password'=>'required|min:8|confirmed']);
        if(!Hash::check($request->current_password,$request->user()->password))
            throw ValidationException::withMessages(['current_password'=>['Incorrect password.']]);
        $request->user()->update(['password'=>$request->password]);
        return response()->json(['message'=>'Password updated.']);
    }
}