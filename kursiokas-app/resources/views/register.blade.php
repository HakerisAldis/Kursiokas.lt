
<!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-register" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row justify-content-center">
					<div class="card-body justify-content-center">

						<div class="form-register row justify-content-center">
							<h5 class="modal-title">Registracija</h5>
						</div>

					    <form method="POST" action="{{ route('register') }}">
					        @csrf

							<div class="form-register row justify-content-center">
					        	<div class="col-md-10">
					                <input placeholder="Vardas" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

									@error('name')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
					        	</div>
					        </div>

							<div class="form-register row justify-content-center">
					        	<div class="col-md-10">
					                <input placeholder="Pavardė" id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" required autocomplete="lastName" autofocus>

									@error('lastName')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
					        	</div>
					        </div>

					        <div class="form-register row justify-content-center">
					        	<div class="col-md-10">
					                <input placeholder="El. paštas" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

					                @error('email')
					                    <span class="invalid-feedback" role="alert">
					                        <strong>{{ $message }}</strong>
					                    </span>
					                @enderror
					        	</div>
					        </div>

							<div class="form-register row justify-content-center">
					        	<div class="col-md-10">
					                <input placeholder="Gimimo data" id="birthDate" type="date" class="form-control @error('birthDate') is-invalid @enderror" name="birthDate" value="{{ old('birthDate') }}" required autocomplete="birthDate" autofocus>

					                @error('birthDate')
					                    <span class="invalid-feedback" role="alert">
					                        <strong>{{ $message }}</strong>
					                    </span>
					                @enderror
					        	</div>
					        </div>

							<div class="form-register row justify-content-center">
					        	<div class="col-md-10">
					                <input placeholder="Telefono numeris" id="phoneNumber" type="tel" class="form-control @error('phoneNumber') is-invalid @enderror" name="phoneNumber" value="{{ old('phoneNumber') }}" required autocomplete="phoneNumber" autofocus>

					                @error('phoneNumber')
					                    <span class="invalid-feedback" role="alert">
					                        <strong>{{ $message }}</strong>
					                    </span>
					                @enderror
					        	</div>
					        </div>

					        <div class="form-register row justify-content-center">
					            <div class="col-md-10">
					                <input placeholder="Slaptažodis" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

					                @error('password')
					                    <span class="invalid-feedback" role="alert">
					                        <strong>{{ $message }}</strong>
					                    </span>
					                @enderror
					            </div>
					        </div>

							<div class="form-register row justify-content-center">
					            <div class="col-md-10">
					                <input placeholder="Pakartokite slaptažodį" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">

					                @error('password')
					                    <span class="invalid-feedback" role="alert">
					                        <strong>{{ $message }}</strong>
					                    </span>
					                @enderror
					            </div>
					        </div>

					        <div class="form-group row justify-content-center">
					        	<p>Jau esate prisiregistravę? <a href="" data-dismiss="modal" data-toggle="modal" data-target="#loginModal">Spauskite čia</a></p>
					        </div>

					        <div class="form-register row justify-content-center">
				                <button type="submit" class="btn btn-secondary">
				                    {{ __('Registruotis') }}
				                </button>
			        		</div>
			    		</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
