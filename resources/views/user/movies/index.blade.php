@extends('user.layouts.movies')
@section('content')
<div class="main-container">
<div class="another-nav">
  <div class="row">
    <div class="col-md-8">
      <a href="#" class="my-link"><strong>SHOW ALL</strong></a>
      <a href="#" class="another-link my-link"><strong>TOP MOVIES</strong></a>
      <a href="#" class="another-link my-link"><strong>NEW RELEASES</strong></a>
    </div>
    <div class="col-md-4 pull-right">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
      <div class="input-group-append">
      <button class="btn btn-success btn-sm">Go!</button>
    </div>
    </div>
  </div>
    </div>
</div>
<br>
<br>
<h6 class=""><strong>TOP MOVIES</strong> </h6>
<div class="row row2 text-center">
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie1.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie2.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie3.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie4.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie5.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie6.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
</div>
<br><br>
<h6 class=""><strong>NEW RELEASES</strong> </h6>
<div class="row row2 text-center">
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie1.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie2.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie3.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie4.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie5.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
  <div class="column col-lg-2 col-sm-6 col-md-4">
    <div class="movie-image">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie6.jpg">

        <div class="overlay">
           <h2>Spider Man 3</h2>
           <a class="info" href="/movies/show">Watch</a>
        </div>
        </div>
    </div>
  </div>
</div>
</div>
@endsection