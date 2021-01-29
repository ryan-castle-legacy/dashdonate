<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;




// Include DashDonate API
use \App\Http\Controllers\DashDonate as API;




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
			'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
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
        $user = User::create([
			'firstname' 			=> $data['firstname'],
			'lastname' 				=> $data['lastname'],
            'name' 					=> $data['firstname'].' '.$data['lastname'],
            'email' 				=> $data['email'],
			'password' 				=> Hash::make($data['password']),
			'created_at' 			=> date('Y-m-d H:i:s', time()),
			'user_role' 			=> 'donor',
            'email_confirm_code' 	=> rand(1000, 9999),
        ]);
		// Send API request to confirm user as verified
		$send = API::sendEmailToConfirm($data['email'], true);
		// Send user data
		return $user;
    }




}
