@extends('user.layouts.app')

@section('content')
<nav class="navbar sticky-top navbar-expand-lg navbar-inverse navbar-dark navbar-trans header">
  <a class="navbar-brand" href="#">LOGO</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
    </ul>
    <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      ENG
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">RUS</a>
                        <a class="dropdown-item" href="#">KOR</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-1x"></i></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

    <!--
    <form class="form-inline my-2 my-lg-0">
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text glyphicon glyphicon-search" id="basic-addon1">@</span>
        </div>
      <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
    </div>
    </form> 
  -->
  </div>
</nav>


<div class="row">
	<div class="col-md-6 col-xs-12 padding-0">
		<div class="music">
			<div class="icon-box">
                <a href="/music">
                    <div class="my-box">
                        <i class="fa fa-5x fa-headphones"></i>
                        <h4><strong>LISTEN</strong></h4>
                    </div>
                </a>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-xs-12 padding-0">
		<div class="movies">
			<div class="icon-box">
				<a href="/movies">
				<div class="my-box" >
					<i class="fa fa-video-camera fa-5x"></i>
					<h4><strong>WATCH</strong></h4>
				</div>
				</a>
			</div>
		</div>
	</div>
</div>

<nav class="navbar fixed-bottom navbar-inverse navbar-trans footer">
  <p class="pull-right">
  	<strong>{{ Auth::user()->name }}</strong><br>
  	First Class
  </p>
  <p class="pull-left">
  	<strong>F-102</strong><br>
  	Seat
  </p>
</nav>
@endsection
