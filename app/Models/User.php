<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token') ? Session::get('_token') : '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function SignInWithMobile($data)
    {
        // dd($data);
        $loginData = [
            "contactNumber" => $data['contactNumber'],
            "deviceType" => "web",
            "pushId" => "",

        ];
        // dd(json_encode($loginData));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];

        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/SignInWithMobile', $loginData)->json();
        //dd($res);
        return $res;
    }
    public static function SignIn($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/SignIn', $data)->json();
        return $res;
    }
    public static function User($id, $header_token = "")
    {
        $header_token = $header_token == '' ? Session::get('_token') : $header_token;

        $headers = ["Authorization" => "Bearer " . $header_token, "Accept" => "*"];

        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/User/' . $id)->json();

        return $res;
    }

    public static function getUsers()
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/Users')->json();
        return $res;
    }
    ///api/Auth/EmailExistCheck/{email}
    public static function EmailExistCheck($email)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/EmailExistCheck/' . $email)->json();
        return $res;
    }
    ///api/Auth/UserNameCheck/{userName}
    public static function UserNameCheck($userName)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/UserNameCheck/' . $userName)->json();
        return $res;
    }
    ///api/Auth/ContactNoExistCheck/{contactNo}
    public static function ContactNoExistCheck($contactNo)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Auth/ContactNoExistCheck/' . $contactNo)->json();
        return $res;
    }
    ///api/Auth/ResendOTP
    public static function ResendOTP($contactNumber)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/ResendOTP', $contactNumber)->json();
        return $res;
    }
    public static function createUser($data)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/CreateUser', $data);
        return $res;
    }
    public static function updateUser($data)
    {
        // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/UpdateUser', $data);
        return $res;
    }
    public static function deleteUser($id, $deletedBy)
    {
        //  dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/DeleteUser/' . $id . '/' . $deletedBy);
        //dd($res);
        return $res;
    }
    ///api/Auth/UserListByEmployeeId [POST [{  "userId": "string",  "roleName": "string",   "officeId": "string" }]]
    public static function UserListByEmployeeId($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/UserListByEmployeeId', $data)->json();
        return $res;
    }
    ///api/Auth/ResetPassword
    public static function ResetPassword($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/ResetPassword', $data)->json();
        return $res;
    }
    ///api/Auth/ChangePassword
    public static function ChangePassword($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/ChangePassword', $data)->json();
        return $res;
    }
    ///api/Auth/RefreshToken post { { "jwtToken": "string", "refreshToken": "string" }}
    public static function RefreshToken($data)
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Auth/RefreshToken', $data)->json();
        return $res;
    }
}
