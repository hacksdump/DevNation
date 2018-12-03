<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Controllers\UserController;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function checkLogin(Request $request)
    {
        $rules = array(
            'username' => 'required|max:25',
            'password' => 'required|max:25',
        );

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            // username or password missing
            // validation fails
            // used to retain input values
            $request->flash();

            // return to login page with errors
            return Redirect::to('/login')
                ->withInput()
                ->withErrors($v->messages());

        } else {
            $userdata = array(
                'username' => Input::get('username'),
                'password' => Input::get('password')
            );
            if (Auth::attempt($userdata)) {
                return Redirect::to('/');
            } else {
                $errors = [];
                $userExists = UserController::userExists(Input::get('username'));
                if($userExists){
                    $errors['password'] = 'Wrong password';

                }
                else{
                    $errors['username'] = 'User does not exist';
                }

                return Redirect::to('login')
                    ->withInput()
                    ->withErrors($errors);
            }
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}
