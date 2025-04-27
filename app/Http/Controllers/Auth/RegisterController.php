<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Http\Controllers\Controller;
use App\Models\Hobby;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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

    public function showRegistrationForm(){
        try {
            $states = State::select('id','name')->orderBy('name')->get(); 
            $hobbies = Hobby::select('id','name')->orderBy('name')->get(); 
            
            return view('auth.register', compact('states','hobbies'));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function getCities($state_id){
        try {
            $cities = City::where('state_id', $state_id)->pluck('name', 'id');
            return response()->json($cities);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
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
            'password' => Hash::make($data['password']),
        ]);
    }
}
