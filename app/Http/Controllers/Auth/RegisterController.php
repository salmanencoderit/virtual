<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use View;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'wedding' => ['required', 'date'],
        ]);
    }

    public function insertAPI(Request $request, $firstname, $lastname, $email, $company, $sector, $messe)
  {
      $permitted = "123456789ABCDEFG";
      $password = substr(str_shuffle($permitted), 0, 8);

      $user = User::create([
          'name' => $firstname,
          'lastname' => $lastname,
          'email' => $email,
          'role' => 1,
          'company' => $company,
          'sector' => $sector,
          'password' => bcrypt($password)
      ]);

      return view('notification', compact('user', 'password', 'messe'));
  }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'wedding' => Carbon::parse($data['wedding'])->format("Y-m-d"),
            'password' => Hash::make($data['password']),
        ]);
    }
}
