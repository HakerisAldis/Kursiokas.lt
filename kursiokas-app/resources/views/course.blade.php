<div class="row justify-content-center w-75 border-bottom pb-2 h-auto course-div" onclick="window.location.href='/courses/{{ $course->id }}';">
	<div class="row align-items-center col-2">
		<img src="{{asset($course->image)}}" class="img-thumbnail" alt="Kurso nuotrauka">
	</div>

	<div class="card-body align-items-center mt-2 col-4">
		<div>
			@if($course->registeringAllowed == 1)
				<h1 class="course-title">{{ $course->name }}</h1>
			@else
				<h1 class="course-title">{{ $course->name }} (Registracija uždaryta)</h1>
			@endif
		</div>
		<div>
			<p>{{ $course->scope }}</p>
		</div>
	</div>

	<div class="row align-items-center mt-2 col-3">
		<div class="row container">
			<p class="w-100 text-center">{{ $course->date }}</p>
			<p class="w-100 text-center">{{ date('H:i', strtotime($course->time)) }}</p>
		</div>
	</div>

	<div class="row align-items-center mt-2 col-3">
		<p class="w-100 text-center">{{ $course->city }}</p>
	</div>
</div>

<script>
	$("#kursas").click(function() {
		alert('Veikia');
		window.location = $(this).attr("data-location");
		return false;
	});
</script>
