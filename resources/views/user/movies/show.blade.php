@extends('user.layouts.movies') 
@section('content')
<video class="video_player" id="player" width="100%" controls="controls" autoplay="autoplay">
  <source src="videos/HAHAHA.wmv">
  Your browser does not support the HTML5 video tag.  Use a better browser!
</video>
<img src="/images/movieinfo.jpg" id="bg" alt="">
<div class="container">
  <div class="row">
  <div class="col-lg-2">
    <div class="movie-images">
      <div class="hovereffect">
        <img class="mubi" src="/images/movie1.jpg">

        <div class="overlay">
           <h2>Avengers: Infinity War</h2>
           <a class="info" href="movies-info.html"><i class="fas fa-play"></i></a>
        </div>
        </div>
    
    </div>
    
  </div>
  <div class="col-lg-8 title">
    <div class="movie-imagesss">
      <div class="title">
        <h5><strong>Avengers: Infinity War</strong></h5>
        <h6>2018-04-25 &nbsp;&nbsp;&nbsp;<i class="fas fa-clock"></i>&nbsp;&nbsp;&nbsp; 2:45:02</h6>
        <h6>Action | Adventure | Fantasy</h6>
      </div>
    </div>
  </div>
  <div class="col-lg-2">
    <div class="movie-image">
      
      <div class="hovereffect">
        <a class="my-link" href="movies.html">
        <h6><i class="fas fa-angle-left"></i> &nbsp;&nbsp;&nbsp;<strong>Go Back</strong></h6>
      </a>
      </div>
    </div>
  </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
    <h6>Having acquired the Power Stone from the planet Xandar, Thanos and his lieutenants—Ebony Maw, Cull Obsidian, Proxima Midnight, and Corvus Glaive—intercept the spaceship carrying the survivors of Asgard's destruction.[N 1] They extract the Space Stone from the Tesseract, Thor is subdued, and Thanos overpowers Hulk and kills Loki. Heimdall sends Hulk to Earth using the Bifröst before being killed. Thanos departs with his lieutenants and obliterates the spaceship.</h6>
  </div>
  </div>
  <div class="row">
    <div class="col-lg-12"><br><br>
    <h6><strong>Director:</strong> Anthony Russo and Joe Russo</h6>
    <h6><strong>Writer:</strong>  Christopher Markus</h6>
    <h6><strong>Cast:</strong> Robert Downey Jr.,
Chris Hemsworth,
Mark Ruffalo,
Chris Evans,
Scarlett Johansson,
Benedict Cumberbatch,
Don Cheadle,
Tom Holland,
Chadwick Boseman,
Paul Bettany,
Elizabeth Olsen,
Anthony Mackie,
Sebastian Stan,
Danai Gurira,
Letitia Wright,
Dave Bautista,
Zoe Saldana,
Josh Brolin,
Chris Pratt</h6>
  <h6><strong>Classification:</strong> R15+</h6>
  <h6><strong>Reference:</strong> IMDb</h6>
    </div>
  </div>
</div>
@endsection