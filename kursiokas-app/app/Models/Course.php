<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserType;

class Course extends Model
{
    use HasFactory;

	public $timestamps = false;

	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	public function getCourseUsers()
	{
       	$course = $this->users();
       	if(User::isLecturer()){
       		$course = $course->where('lecturer_id', User::getId());
        }

        $users = $course->where('type', UserType::Member);

       	return $users->get();
	}

	protected $fillable = [
		'name',
		'date',
		'time',
		'seats',
		'address',
		'price',
		'description',
		'city',
		'registeringAllowed',
		'image',
    ];

	public function isRegistered($userId) {
		return $this->users()->where("user_id", $userId)->first() != null ? true : false;
	}
}
