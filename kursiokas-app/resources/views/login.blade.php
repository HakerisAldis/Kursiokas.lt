
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-login" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row justify-content-center">
					<div class="card-body justify-content-center">

						<div class="form-login row justify-content-center">
							<h5 class="modal-title">Prisijungimas</h5>
						</div>

					    <form method="POST" action="{{ route('login') }}">
					        @csrf

					        <div class="form-login row justify-content-center">
					        	<div class="col-md-10">
					                <input placeholder="El. paštas" id="email" type="email" class="form-control @error('login_email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

					                @error('login_email')
					                    <span class="invalid-feedback" role="alert">
					                        <strong>{{ $message }}</strong>
					                    </span>
					                @enderror
					        	</div>
					        </div>

					        <div class="form-login row justify-content-center">
					            <div class="col-md-10">
					                <input placeholder="Slaptažodis" id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
							    </div>
					        </div>

					        <div class="form-login row justify-content-center">
					        	<p>Vis dar nesate prisiregistravę? <a href="" data-dismiss="modal" data-toggle="modal" data-target="#registerModal">Spauskite čia</a></p>
					        </div>

					        <div class="form-login row justify-content-center">
				                <button type="submit" class="btn btn-secondary">
				                    {{ __('Prisijungti') }}
				                </button>
			        		</div>
			    		</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
