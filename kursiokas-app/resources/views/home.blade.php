@extends('layouts.app')

@section('content')
<div class="justify-content-center row">
	<div class="pt-1 card-body justify-content-center container border-bottom">
		<div id="main-title" class="row justify-content-center">
			<h1 class="main-title">Kurso pasirinkimas</h1>
		</div>

		<form method="GET">
			<div class="row justify-content-center">
				<div class="input-group row  mr-2 ml-2 w-15">
					<select class="custom-select" id="inputGroupSelect01" name="city">
						<option value="" hidden selected>Miestas</option>

						@for($i = 0; $i < count($cities); $i++)
							@if (app('request')->input('city') == $cities[$i])
								<option value="{{ $cities[$i] }}" selected>{{ $cities[$i] }}</option>
							@else
								<option value="{{ $cities[$i] }}">{{ $cities[$i] }}</option>
							@endif
						@endfor
					</select>
				</div>

				<div class="input-group row  mr-2 ml-2 w-15">
					<select class="custom-select" id="inputGroupSelect01" name="scope">
						<option value="" hidden selected>Sritis</option>
						@for($i = 0; $i < count($scopes); $i++)
							@if (app('request')->input('scope') == $scopes[$i])
								<option value="{{ $scopes[$i] }}" selected>{{ $scopes[$i] }}</option>
							@else
								<option value="{{ $scopes[$i] }}">{{ $scopes[$i] }}</option>
							@endif
						@endfor
					</select>
				</div>

				<div class="input-group row  mr-2 ml-2 w-15">
					<input name="name" type="text" class="form-control" placeholder="Tesktinė paieška" aria-label="Search" aria-describedby="basic-addon1">
				</div>

				<div class="input-group row  mr-2 ml-2 w-10">
					<input type="submit" class="btn btn-secondary w-100" value="Ieškoti">
				</div>
			</div>
		</form>
	</div>

	<div class="pt-2 card-body row justify-content-center container">
		@foreach ($courses as $course)
			@include('course', ['course' => $course])
		@endforeach
	</div>
</div>
@if (session("status"))
			<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModal">
				<div class="modal-dialog modal-confirmation" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Kurso pašalinimas</h5>
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
@endsection
