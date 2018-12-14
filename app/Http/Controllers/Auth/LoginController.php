<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\User;
use phpDocumentor\Reflection\Types\Self_;
use phpDocumentor\Reflection\Types\Static_;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected static $providers = ['google', 'github'];

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

    public function redirectToProvider($provider)
    {
        if(in_array($provider, self::$providers)){
            return Socialite::driver($provider)->redirect();
        }
    }

    public function handleProviderCallback($provider)
    {
        if(in_array($provider, self::$providers)){
            try {
                $user = Socialite::driver($provider)->user();
            } catch (\Exception $e) {
                return Redirect::to('/login');
            }
        }

        $existingUser = UserController::findUserByEmail($user->email);

        if($existingUser){
            Auth::login($existingUser, true);
            return Redirect::to('/');
        } else {
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->google_id       = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            Session::put('newUser', $newUser);
            return view('get_username')->with('name', $user->name, ' ');
        }
    }

    public function getUsernamePwdAfterOauth(Request $request)
    {
        $newUser = Session::get('newUser');
        $v = $this->oauthRegistrationValidator($request->all());
        if ($v->fails()) {
            $request->flash();
            return view('get_username')
                ->with('name', $newUser->name)
                ->withErrors($v->messages());
        } else {
            $newUser->username = $request->get('username');
            $newUser->password = Hash::make($request->get('password'));
            $newUser->save();
            Auth::login($newUser);
            Session::forget('newUser');
            return Redirect::to('/');
        }
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
            $emailOrUsername = Input::get('username');
            $password = Input::get('password');
            if(strpos($emailOrUsername, '@')){
                $userdata = array(
                    'email' => $emailOrUsername,
                    'password' => $password
                );
            }
            else {
                $userdata = array(
                    'username' => $emailOrUsername,
                    'password' => $password
                );
            }

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

    protected function oauthRegistrationValidator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'string', 'max:20', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    protected function registrationFormValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'username' => ['required', 'string', 'string', 'max:20', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    protected function registerUser(Request $request)
    {
        $v = $this->registrationFormValidator($request->all());
        if ($v->fails()) {
            $request->flash();
            return Redirect::to('/register')
                ->withInput()
                ->withErrors($v->messages());

        } else {
            $userdata = array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'username' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
            );
            $user = User::create($userdata);
            Auth::login($user);
            return Redirect::to('/');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }



}
