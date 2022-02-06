@extends('layouts.app')

@section('content')
<div class="justify-content-center row">
	<div class="pt-1 card-body justify-content-center container border-bottom row">

		<div class="col-3">
			<div class="input-group row mr-2 ml-2 w-100">
			  	<img src="{{asset($course->image)}}" class="img-thumbnail" alt="Kurso nuotrauka">
			</div>
		</div>

		<div class="col-9">
			<div class="row ml-2 mb-0">
				@if($course->registeringAllowed == 1)
					<h1 class="main-title pb-0 text-break h-auto">{{ $course->name }}</h1>
				@else
					<h1 class="main-title pb-0 text-break h-auto">{{ $course->name }} (Registracija uždaryta)</h1>
				@endif
			</div>

			<div class="row ml-2 mb-1">
				<p class="pt-0 pb-0 text-break h-auto">{{ $course->scope }}</p>
			</div>

			<div class="row">
				<div class="ml-2 col-4">
					<div>
						<h5 class="mb-1">Vieta:</h5>
						<div class="mb-0 h-auto text-break">{{ $course->address }}</div>
						<div class="mb-0 h-auto text-break">{{ $course->city }}</div>
					</div>
				</div>

				<div class="col-2 h-auto border-left">
					<h5 class="mb-1">Data:</h5>
					<div class="mb-0 h-auto text-break">{{ $course->date }}</div>
					<div class="mb-0 h-auto text-break">{{ date('H:i', strtotime($course->time)) }}</div>
				</div>

				<div class="col-2 h-auto border-left">
					<h5 class="mb-1">Kurso kaina:</h5>
					<div class="mb-0 h-auto text-break">{{ $course->price }} €</div>
				</div>

				<div class="col-3 h-auto border-left">
					<h5 class="mb-1">Vietų skaičius:</h5>
					<div class="mb-0 h-auto text-break">{{ $course->seats }}</div>
				</div>
			</div>
		</div>
	</div>

	<div class="pt-3 card-body container row">
		<div class="col">
			<div class="row">
				<h1 class="main-title pb-0 text-break h-auto">Kurso aprašymas:</h1>
			</div>

			<div class="row h-auto text-break">
				{{ $course->description }}
			</div>
		</div>
	</div>

	<div class="pt-3 container">
		@auth
		@if (Auth::user()->isMember())
			@if($course->isRegistered(Auth::user()->getId()))
				<div class="col d-flex justify-content-end">
					<button type="button" class="btn btn-danger w-15" data-toggle="modal" data-target="#cancelModal">
						Atšaukti registraciją
					</button>
				</div>

				<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModal" aria-hidden="true">
					<div class="modal-dialog modal-confirmation" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Registracijos atšaukimas</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								Ar tikrai norite atšaukti registraciją į kursą „{{ $course->name }}“?
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Atšaukti</button>
								<form method="POST" action="{{ route('course.cancel', ['id' => $course->id]) }}">
									@csrf
									<button type="submit" class="btn btn-danger">Atšaukti registraciją</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			@else
				<div class="col d-flex justify-content-end">
					<button type="button" class="btn btn-secondary w-15" data-toggle="modal" data-target="#confirmationModal">
						Registruotis į kursą
					</button>
				</div>

				<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModal" aria-hidden="true">
					<div class="modal-dialog modal-confirmation" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Registracijos patvirtinimas</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								Ar tikrai norite užsiregistruoti į kursą „{{ $course->name }}“?
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Atšaukti</button>
								<form method="POST" action="{{ route('course.register', ['id' => $course->id]) }}">
									@csrf
									<button type="submit" class="btn btn-secondary">Patvirtinti registraciją</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			@endif
		@endif

		@if (Auth::user()->isLecturer())
			<div class="container row d-flex justify-content-end">
				<input type="submit" class="btn btn-secondary ml-1" value="Užsiregistravę dalyviai" data-toggle="modal" data-target="#participantsModal">
			</div>

			<div class="modal fade" id="participantsModal" tabindex="-1" role="dialog" aria-labelledby="participantsModal" aria-hidden="true">
			<div class="modal-dialog modal-confirmation modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-center" id="exampleModalLabel">{{ $course->name }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="font-weight-bold">Dalyviai:</p>
						@foreach ($course->getCourseUsers() as $user)
							<div class="row d-flex align-middle justify-content-between mr-1 ml-1 pl-2 pr-2 border-bottom">
								<div>
									<p class="mb-2 mt-2">{{ $user->name }} {{ $user->surname }}</p>
								</div>
								<div>
									<p class="mb-2 mt-2">{{ $user->email }}</p>
								</div>
							</div>
						@endforeach
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Išjungti</button>
					</div>
				</div>
			</div>
		</div>
		@endif

		@if (Auth::user()->isAdmin())
		<div class="container row d-flex justify-content-end">
            <input type="submit" class="btn btn-secondary ml-1" value="Priskirti dėstytojus" data-toggle="modal" data-target="#assignLecturersModal">
			@if ($course->registeringAllowed == 1)
			<input type="submit" class="btn btn-secondary ml-1" value="Uždaryti registraciją" data-toggle="modal" data-target="#closeModal">
			@else
			<input type="submit" class="btn btn-secondary ml-1" value="Atidaryti registraciją" data-toggle="modal" data-target="#openModal">
			@endif
			<input type="submit" class="btn btn-secondary ml-1" value="Užsiregistravę dalyviai" data-toggle="modal" data-target="#participantsModal">
			<form method="GET" action="{{ route('course.edit', ['id' => $course->id]) }}">
				<input type="submit" class="btn btn-secondary ml-1" value="Redaguoti kursą">
			</form>
			<input type="submit" class="btn btn-danger ml-1" value="Pašalinti kursą" data-toggle="modal" data-target="#deleteModal">
        </div>

		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
			<div class="modal-dialog modal-confirmation" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Kurso pašalinimas</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						Ar tikrai norite pašalinti kursą „{{ $course->name }}“?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Atšaukti</button>
						<form method="POST" action="{{ route('course.destroy', ['id' => $course->id]) }}">
							@csrf	
							<button type="submit" class="btn btn-danger">Pašalinti</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="closeModal" tabindex="-1" role="dialog" aria-labelledby="closeModal" aria-hidden="true">
			<div class="modal-dialog modal-confirmation" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Kurso registracijos uždarymas</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						Ar tikrai norite uždaryti registraciją į kursą „{{ $course->name }}“?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Atšaukti</button>
						<form method="POST" action="{{ route('course.close', ['id' => $course->id]) }}">
							@csrf
							<button type="submit" class="btn btn-danger">Uždaryti</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="openModal" aria-hidden="true">
			<div class="modal-dialog modal-confirmation" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Kurso registracijos atidarymas</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						Ar tikrai norite atidaryti registraciją į kursą „{{ $course->name }}“?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Atšaukti</button>
						<form method="POST" action="{{ route('course.open', ['id' => $course->id]) }}">
							@csrf
							<button type="submit" class="btn btn-secondary">Atidaryti</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="participantsModal" tabindex="-1" role="dialog" aria-labelledby="participantsModal" aria-hidden="true">
			<div class="modal-dialog modal-confirmation modal-dialog-scrollable" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-center" id="exampleModalLabel">Dalyvių sąrašas</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="font-weight-bold">Dalyviai:</p>
						@foreach ($course->getCourseUsers() as $user)
							<div class="row d-flex align-middle justify-content-between mr-1 ml-1 pl-2 pr-2 border-bottom">
								<div>
									<p class="mb-2 mt-2">{{ $user->name }} {{ $user->surname }}</p>
								</div>
								<div>
									<p class="mb-2 mt-2">{{ $user->email }}</p>
								</div>
							</div>
						@endforeach
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Išjungti</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="assignLecturersModal" tabindex="-1" role="dialog" aria-labelledby="assignLecturersModal" aria-hidden="true">
			<div class="modal-dialog modal-confirmation" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title text-center" id="exampleModalLabel">Priskirti dėstytojus</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form method="POST" action="{{ route('course.assign', ['id' => $course->id]) }}">
					@csrf
					<div class="modal-body">
						<p class="font-weight-bold">Dalyviai:</p>
						<div id="append-input" class="row d-flex align-middle justify-content-between mr-1 ml-1 pl-2 pr-2">

							<div class="input-group mb-1">
								<select class="custom-select" name="lecturer_id[]" required>
									<option value="" selected hidden>Pasirinkite...</option>
									@foreach (Auth::user()->getLecturers() as $lecturer)
										@if(count($lecturers) > 0 && $lecturers[0]->id == $lecturer->id)
											<option value="{{ $lecturer->id }}" selected>{{ $lecturer->name }} {{ $lecturer->surname }}</option>
										@else
											<option value="{{ $lecturer->id }}">{{ $lecturer->name }} {{ $lecturer->surname }}</option>
										@endif
									@endforeach
								</select>
								<div class="input-group-append">
									<button class="btn btn-secondary pr-3 pl-3" type="button" onclick="add()"><i class="fas fa-plus"></i></button>
								</div>
							</div>
								@for ($i = 1; $i < count($lecturers); $i++)
								<div class="input-group mb-1">
									<select class="custom-select" name="lecturer_id[]">
										<option value="" selected hidden>Pasirinkite...</option>
										@foreach (Auth::user()->getLecturers() as $lecturer)
											@if(isset($lecturers) && $lecturers[$i]->id == $lecturer->id)
												<option value="{{ $lecturer->id }}" selected>{{ $lecturer->name }} {{ $lecturer->surname }}</option>
											@else
												<option value="{{ $lecturer->id }}">{{ $lecturer->name }} {{ $lecturer->surname }}</option>
											@endif
										@endforeach
									</select>
									<div class="input-group-append">
										<button class="btn btn-danger" type="button" onclick="remove(this)"><i class="fas fa-minus"></i></button>
									</div>
								</div>
								@endfor
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Išjungti</button>
						<input type="submit" class="btn btn-secondary" value="Priskirti">
					</div>
					</form>
				</div>
			</div>
		</div>
		@endif

		@endauth
		@if (session("status"))
			<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModal">
				<div class="modal-dialog modal-confirmation" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Pranešimas</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							{{ session("status") }}
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Išjungti</button>
						</div>
					</div>
				</div>
			</div>

			<script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.js" type="text/javascript"></script>
			<script type="text/javascript">
				$(window).load(function(){
					$('#statusModal').modal('show');
				});
			</script>
		@endif
	</div>
</div>
<script src="https://kit.fontawesome.com/4af5728c7a.js" crossorigin="anonymous"></script>
@auth
	@if(Auth::user()->isAdmin())
	<script type="text/javascript">
		function add(){
			const div = document.createElement('div');
			div.className = 'input-group mb-1';
			div.innerHTML = `
				<select class="custom-select" name="lecturer_id[]" required>
					<option value="" selected hidden>Pasirinkite...</option>
					@foreach (Auth::user()->getLecturers() as $lecturer)
						<option value="{{ $lecturer->id }}">{{ $lecturer->name }} {{ $lecturer->surname }}</option>
					@endforeach
				</select>
				<div class="input-group-append">
					<button class="btn btn-danger" type="button" onclick="remove(this)"><i class="fas fa-minus"></i></button>
				</div>
			`;
			document.getElementById('append-input').appendChild(div);
		}

		function remove(input) {
			document.getElementById('append-input').removeChild(input.parentNode.parentNode);
		}
	</script>
	@endif
@endauth
@endsection
