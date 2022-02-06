<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserType;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'surname',
        'dateOfBirth',
		'phoneNumber',
        'type',
    ];

	public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
		'email',
		'type',
		'api_token',
		'id',
		'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function courses()
	{
		return $this->belongsToMany(Course::class);
	}

	public static function getType()
	{
		$user = Auth::User();
		if($user != null)
			return $user['type'];	

		return -1;
	}

	public static function getId()
	{
		$user = Auth::User();

		return ($user != null) ? $user['id'] : -1;
	}

	public static function getLecturers()
    {
        $lecturers = DB::table("users")->where("type", UserType::Lecturer);
        return $lecturers->get();
    }

	public static function isAdmin()
	{
		return (User::getType() == UserType::Administrator) ? true : false;
	}

	public static function isAdminOrLecturer()
	{
		$type = User::getType();
		return (User::isLecturer() || User::isAdmin()) ? true : false;
	}

	public static function isLecturer()
	{
		return (User::getType() == UserType::Lecturer) ? true : false;
	}

	public static function isMember()
	{
		return (User::getType() == UserType::Member) ? true : false;
	}

	public static function getApiToken()
	{
		$user = Auth::User();

		return ($user != null) ? $user['api_token'] : -1;
	}
}
