<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function index(){
        $title = "Đăng nhập";
        return view('auth.login',compact('title'));
    }

    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required',
        ]);
        $authenticate = auth()->attempt($request->only('email','password'));
        if(!$authenticate){
            return back()->with('login_error',"Thông tin đăng nhập không hợp lệ");
        }
    
        $user = auth()->user();
        if ($user->role === 0) {
            return redirect()->route('dashboard');
        } elseif($user->role === 1) {
            return redirect()->route('Xemduan');
        }

    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try{
            $google_user=Socialite::driver('google')->user();
            $user=User::where('email', $google_user->getEmail())->first();
            if(!$user)
            {
                $new_user= User::create([
                    'name'=> $google_user->getName(),
                    'username' => 'nguoidungmoi',
                    'password' => '123456',
                    'role' => '1',
                    'google_id'=> $google_user->getId(),
                    'email'=> $google_user->getEmail(),
                    
                ]);
                Auth::login($new_user); 
                return redirect()->intended('Xemduan');
            }
            else{
                Auth::login($user);
                return redirect()->intended('Xemduan');
            }
        }catch(\Throwable $th)
        {
            dd('Đăng nhập bị lỗi ời!'.$th->getMessage());
        }
    }
    
}
