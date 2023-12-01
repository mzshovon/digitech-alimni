<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MembershipDetail;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact' => ['required', 'string', 'max:11', 'unique:users'],
            'nid' => ['required', 'string', 'unique:membership_details,nid'],
            'dob' => ['required', 'string'],
            'address' => ['required', 'string'],
            'blood_group' => ['nullable', 'string'],
            'batch' => ['required', 'string'],
            'employeer_name' => ['nullable', 'string'],
            'designation' => ['nullable', 'string'],
            'employeer_address' => ['nullable', 'string'],
            'reference' => ['nullable', 'string'],
            'reference_number' => ['nullable', 'string'],
            'payment' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg','max:1000'],
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
        $createUser = User::create([
            'name' => $data['first_name']." ".$data['last_name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'password' => Hash::make($data['password']),
        ]);

        if($createUser) {
            $membershipDetailsArray = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'nid' => $data['nid'],
                'dob' => $data['dob'],
                'batch' => $data['batch'],
                'address' => $data['address'],
                'blood_group' => $data['blood_group'],
                'employeer_name' => $data['employeer_name'],
                'designation' => $data['designation'],
                'employeer_address' => $data['employeer_address'],
                'reference' => $data['reference'],
                'reference_number' => $data['reference_number'],
                'payment' => $data['payment'],
                'user_id' => $createUser->id,
                'image_path' => $data['profile_image'] ?? null,
            ];
            if($membershipDetailsArray['image_path']) {
                if($membershipDetailsArray['image_path']){
                    $dirName = storeOrUpdateImage("storage/img/profile/$createUser->id/", $membershipDetailsArray['image_path'], 'profile');
                    $membershipDetailsArray['image_path'] = $dirName;
                } else {
                    unset($membershipDetailsArray['image_path']);
                }
            }
            if(MembershipDetail::createNewMember($membershipDetailsArray)) {
                return $createUser;
            }
        }
    }
}
