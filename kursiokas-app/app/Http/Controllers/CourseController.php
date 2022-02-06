<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use App\Models\Course;
use App\Models\User;
use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
	protected function getCourses(Request $request, $courses)
	{		
		$tempCourses = $courses->unique('city');
		$cities = [];
		foreach($tempCourses as $course){
			array_push($cities, $course['city']);
		}

		$tempCourses = $courses->unique('scope');
		$scopes = [];
		foreach($tempCourses as $course){
			array_push($scopes, $course['scope']);
		}
		
		$city = $request->input('city');
		if($city) $courses = $courses->where('city', $city);

		$scope = $request->input('scope');
		if($scope) $courses = $courses->where('scope', $scope);

		$name = $request->input('name');
		if($name){
			$filtered = [];
			foreach($courses as $course){
				if(str_contains(strtolower($course['name']), strtolower($name))) array_push($filtered, $course);
			}	
			
			$courses = $filtered;
		}

		$data = ['courses' => $courses, 'cities' => $cities, 'scopes' => $scopes];
		
		if($request->input('api_token'))
			return $data;

		return view('home', $data);
	}

	public function token()
	{
		if(User::getType() == UserType::Guest)
			abort(404);

		return ["api_token" => User::getApiToken()];
	}

	public function index(Request $request)
	{
		$courses = Course::get();
		
		if(User::isLecturer()) {
			$array = [];
			$course_user = DB::table("course_user")->select("course_id")->where("lecturer_id", User::getId())->get()->unique('course_id')->toArray();
			foreach($course_user as $course) {
				array_push($array, $course->course_id);
			}
			$courses = Course::find($array);
		}

		return $this->getCourses($request, $courses);
	}

	public function show($id, Request $request)
	{
		$course = Course::findOrFail($id);

		$array = [];
		$course_user = DB::table("course_user")->select("lecturer_id")->where("course_id", $id)->get()->unique('lecturer_id')->toArray();
		foreach($course_user as $lecturer) {
			array_push($array, $lecturer->lecturer_id);
		}
		$lecturers = User::find($array);

		$data = ['course' => $course];

		if($request->input('api_token'))
			return $data;

		return view('ind_course', ['course' => $course, 'lecturers' => $lecturers]);
	}

	public function create()
	{
		if(!User::isAdmin())
			abort(404);

		return view('new_course');
	}

	protected function validator(array $data)
    {
         return \Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
			'date' => ['required', 'date', 'after:today'],
            'time' => ['required', 'date_format:H:i'],
            'seats' => ['required', 'integer'],
            'address' => ['required', 'string'],
			'scope' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'city' => ['required', 'string'],
			'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
		]);
    }

	public function destroy($id, Request $request)
	{
		if(!User::isAdmin())
			abort(404);

		Course::findOrFail($id)->delete();
		return redirect(route('courses'))->with('status', 'Kursas sėkmingai pašalintas!');

	}

	public function assignLecturers($id, Request $request)
	{
		if(!User::isAdmin())
			abort(404);
		
		$this->close($id, $request);	
		$users = Course::findOrFail($id)->users();
		
		$lecturer_ids = $request->input('lecturer_id');

		if(is_null($lecturer_ids))
			return redirect(route('course.show', ['id' => $id]))->with('status', 'Nepriskyrėt jokių dėstytojų!');


		if(count(User::find($lecturer_ids)->where('type', UserType::Lecturer)->toArray()) != count($lecturer_ids))
			return redirect(route('course.show', ['id' => $id]))->with('status', 'Neteisingai pasirinkti dėstytojai!');

		$users = Course::find($id)->users()->get();
		$userCount = $users->count();
		$lecturerCount = count($lecturer_ids);
		
		if($userCount < $lecturerCount)
			return redirect(route('course.show', ['id' => $id]))->with('status', 'Priskirta per daug dėstytojų, neužtenka dalyvių!');

		$usersPerLecturer = (int)($userCount / $lecturerCount);
		$leftOvers = $userCount % $lecturerCount;
		$last = 0;
		$selectedUsers = [];
	
		for($i = 0; $i < $lecturerCount; $i++){
			$assignUserCount = $last + $usersPerLecturer + (($leftOvers > 0) ? 1 : 0);
			for($j = $last; $j < $assignUserCount; $j++){
				array_push($selectedUsers, $users[$j]['id']);
				$last++;
			}
			Course::find($id)->users()->whereIn('user_id', $selectedUsers)->update(['lecturer_id' => $lecturer_ids[$i]]);
			$selectedUsers = [];
			$leftOvers--;
		}

		return redirect(route('course.show', ['id' => $id]))->with('status', 'Dėstytojai priskirti sėkmingai!');
	}

    public function store(Request $request)
   	{
		if(!User::isAdmin())
			abort(404);

		$this->validator($request->all())->validate();

		$imageName = null;

		$imageName = $this->createImage($request);	

		$data = $request->all();

		$id = Course::insertGetId([
			'name' => $data['name'],
			'date' => $data['date'],
			'time' => $data['time'],
			'seats' => $data['seats'],
			'address' => $data['address'],
			'price' => $data['price'],
			'scope' => $data['scope'],
			'description' => $data['description'],
			'city' => $data['city'],
			'image' => $imageName ?? "images/image.png",
		]);

		return redirect(route('course.show', ['id' => $id]));
    }

	public function edit($id)
	{
		if(!User::isAdmin())
			abort(404);

		$course = Course::findOrFail($id);

		return view('edit_course', ['course' => $course]);
	}

	public function users($id, Request $request)
	{
		if(!User::isAdminOrLecturer())
			abort(404);
			
		$course = Course::findOrFail($id)->users();
		if(User::isLecturer()){
			$course = $course->where('lecturer_id', User::getId());
		}
		
		$users = $course->where('type', UserType::Member);

		if($request->input('api_token'))
			return $users->get();

		abort(404);
	}
	
	public function close($id, Request $request)
	{
		if(!User::isAdmin())
			abort(404);
	
		$course = Course::findOrFail($id);
		$course->update([
			'registeringAllowed' => '0'
		]);

		return redirect(route('course.show', ['id' => $id]))->with('status', 'Registracija į šį kursą sėkmingai uždaryta!');
	}

	public function open($id, Request $request)
	{
		if(!User::isAdmin())
			abort(404);
	
		$course = Course::findOrFail($id);
		$course->update([
			'registeringAllowed' => '1'
		]);

		return redirect(route('course.show', ['id' => $id]))->with('status', 'Registracija į šį kursą sėkmingai atidaryta!');
	}
	

	private function createImage(Request $request)
	{	
		if (!isset($request->image))
			return null;

		$imageName = time().'.'.$request->image->extension();  

        $request->image->move(public_path('images'), $imageName);

		return 'images/'.$imageName;
	}

	public function update($id, Request $request)
	{
		if(!User::isAdmin())
			abort(404);

		$this->validator($request->all())->validate();

		$imageName = $this->createImage($request);

		$data = $request->all();

		if (isset($imageName)) {
			$updateData = [
				'name' => $data['name'],
				'date' => $data['date'],
				'image' => $imageName,
				'time' => $data['time'],
				'seats' => $data['seats'],
				'address' => $data['address'],
				'price' => $data['price'],
				'city' => $data['city'],
				'description' => $data['description'],
				'scope' => $data['scope'],
			];
		}
		else {
			$updateData = [
				'name' => $data['name'],
				'date' => $data['date'],
				'time' => $data['time'],
				'seats' => $data['seats'],
				'address' => $data['address'],
				'price' => $data['price'],
				'city' => $data['city'],
				'description' => $data['description'],
				'scope' => $data['scope'],
			];
		}

		Course::findOrFail($id)->update($updateData);

		return redirect(route('course.show', ['id' => $id]));
	}

	public function cancel($id, Request $request)
	{
		$course = Course::findOrFail($id);
		
		if(!User::isMember())
			return redirect(route('course.show', ['id' => $id]))->with('status', 'Tik registruoti naudotojai gali atšaukti registraciją į kursus!');
		
		$course_user = $course->users()->where('user_id', User::getId())->first();
		if(!$course_user)
			return redirect(route('course.show', ['id' => $id]))->with('status', 'Jūs nesate užsiregistravę į šį kursą!');

		DB::table('course_user')->where('course_id', $id)->where('user_id', User::getId())->delete();

		if($request->input('api_token'))
			return ["Message" => "Succesfully unregistered!"];
	
		return redirect(route('course.show', ['id' => $id]))->with('status', 'Registracija sėkmingai atšaukta!');
			 
	}

	public function register($id, Request $request)
	{
		$course = Course::findOrFail($id);

		if(!$course['registeringAllowed'])
			return redirect(route('course.show', ['id' => $id]))->with('status', 'Registracija į šį kursą yra uždaryta!');

		if(!User::isMember())
			return redirect(route('course.show', ['id' => $id]))->with('status', 'Tik registruoti naudotojai gali registruotis į kursus!');

		if(count($course->users()->get()) >= $course->seats)
			return redirect(route('course.show', ['id' => $id]))->with('status', 'Visos vietos į šį kursą yra užimtos!');

		DB::Table('course_user')->insertOrIgnore([
			'course_id' => $id,
			'user_id' => User::getId()
		]);

		if($request->input('api_token'))
			return ["Message" => "Successfully registered!"];
			
		return redirect(route('course.show', ['id' => $id]))->with('status', 'Jūs sėkmingai užsiregistravote į šį kursą!');
	}
}
