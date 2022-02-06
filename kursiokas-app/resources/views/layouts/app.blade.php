<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

	    <!-- CSRF Token -->
	    <meta name="csrf-token" content="{{ csrf_token() }}">

	    <title>{{ config('app.name', 'Kursiokas.lt') }}</title>

	    <!-- Scripts -->
	    <script src="{{ asset('js/app.js') }}" defer></script>

	    <!-- Fonts -->
	    <link rel="dns-prefetch" href="//fonts.gstatic.com">
	    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	    <!-- Styles -->
	    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	</head>
	<body>
	    <div id="app">
	        <nav class="navbar navbar-expand-md navbar-light shadow-sm pb-2 pt-2">
	            <div class="container">
	                <a href="{{ url('/') }}">
	                    <img src="{{asset('logo.png')}}" width="150px">
	                </a>
	                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
	                    <span class="navbar-toggler-icon"></span>
	                </button>

	                <div class="collapse navbar-collapse" id="navbarSupportedContent">
	                    <!-- Left Side Of Navbar -->
	                    <ul class="navbar-nav mr-auto">

	                    </ul>

	                    <!-- Right Side Of Navbar -->
	                    <ul class="navbar-nav ml-auto">
	                        <!-- Authentication Links -->
	                        @guest
							@include('login')
							@include('register')
							@if($errors->any())
								@if(@isset($errors->messages()['login_email']))
									<script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.js" type="text/javascript"></script>
									<script type="text/javascript">
										$(window).load(function(){
										$('#loginModal').modal('show');
										});
									</script>
								@else
								<script src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.js" type="text/javascript"></script>
								<script type="text/javascript">
									$(window).load(function(){
									$('#registerModal').modal('show');
									});
								</script>
								@endif
							@endif
								<button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-target="#loginModal">
								 	{{ __('Prisijungti') }}
								</button>

								<button type="button" class="btn btn-primary ml-1" data-toggle="modal" data-target="#registerModal">
									{{ __('Registruotis') }}
								</button>
	                        @else
								@if (Auth::user()->isAdmin())
									<form method="GET" action="{{ route('course.create') }}">
										<button type="submit" class="btn btn-primary ml-1 mr-2">
										{{ __('Pridėti kursą') }}
										</button>
									</form>
								@endif
	                            <li class="nav-item dropdown">
	                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
	                                    {{ Auth::user()->name }}
	                                </a>

	                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
	                                    <a class="dropdown-item" href="{{ route('logout') }}"
	                                       onclick="event.preventDefault();
	                                                     document.getElementById('logout-form').submit();">
	                                        {{ __('Atsijungti') }}
	                                    </a>

	                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
	                                        @csrf
	                                    </form>
	                                </div>
	                            </li>
	                        @endguest
	                    </ul>
	                </div>
	            </div>
	        </nav>

	        <main class="py-4">
	            @yield('content')
	        </main>
	    </div>
	</body>
</html>
