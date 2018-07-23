@extends('admin.layouts.app') @section('css')
 @section('content')
<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
    <a href="/admin/movies">Movies</a> &nbsp; <span data-feather="chevron-right"></span> &nbsp;{{$movie->title}}
</div>

{!! Form::open(['action' => ['Admin\MoviesController@update', $movie->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'])
!!}
<div class="row">
    <div class="col-md-5 col-sm-5">
        {{Form::label('title', 'Title')}} {{Form::text('title', $movie->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="col-md-3 col-sm-3">    
        {{Form::label('category', 'Category')}} 
        {{Form::select('category', $categories, $movie->category_id, ['class' => 'form-control', 'placeholder' => 'Select a category...'])}}
    </div>
    <div class="col-md-2 col-sm-2">
        {{Form::label('ewallet_price', 'E-Wallet Price')}} {{Form::number('ewallet_price', $moviePriceEWallet, ['class' => 'form-control ewallet-price', 'placeholder' => 'Enter E-Wallet Price'])}}
    </div>
    <div class="col-md-2 col-sm-2">
        {{Form::label('token_price', 'Token Price')}} {{Form::number('token_price', $moviePriceToken, ['class' => 'form-control token-price', 'placeholder' => 'Enter Token Price'])}}
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-5 col-sm-5">
        {{Form::label('cast', 'Casts')}} {{Form::text('cast', $movie->cast, ['class' => 'form-control', 'placeholder' => 'Mikhaela Maun, Regina Lopez, Joyce Feliciano, Jessica Gomez'])}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('running_time', 'Running Time')}}
        {{Form::number('running_time', $movie->running_time, ['class' => 'form-control', 'placeholder' => 'Enter movie time (minutes)'])}}
    </div>
    <div class="col-md-2 col-sm-2">    
        {{Form::label('release_date', 'Release Date')}} {{Form::date('release_date', $movie->release_date, ['class' => 'form-control'])}}
    </div>
    <div class="col-md-2 col-sm-2">
        {{Form::label('language', 'Language')}} {{Form::select('language', ['English' => 'English', 'Chinese' => 'Chinese'], $movie->language,
        ['class' => 'form-control', 'placeholder' => 'Select a language...'])}}
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        <div class="card card-body bg-light">
            {{Form::label('genre', 'Genre')}}
            <div class="row">
                @foreach($genres as $genre)
                <div class="col-md-3 col-sm-3">
                    @if(in_array($genre->name, $movie_genres)) {{Form::checkbox('genres[]', $genre->name, ['checked' => 'checked'])}} &nbsp;{{$genre->name}}
                    @else {{Form::checkbox('genres[]', $genre->name)}} &nbsp;{{$genre->name}} @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('movie_video', 'Full Movie')}}
        <br> {{Form::file('movie_video')}}
        <br><br>
        {{Form::label('cover_image', 'Cover Image')}}
        <br> {{Form::file('cover_image')}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('trailer_video', 'Trailer')}}
        <br> {{Form::file('trailer_video')}}
    </div>
</div>
<br>
<br>
<div class="form-group">
    {{Form::label('movie_description', 'Movie Description')}} {{Form::textarea('movie_description', $movie->movie_description, ['class' => 'form-control',
    'placeholder' => 'Enter movie description here'])}}
</div>
<div class="form-group">
    {{Form::hidden('_method', 'PUT')}} {{Form::submit('Save', ['class' => 'btn btn-success'])}} {!! Form::close() !!}
    <a href="/admin/movies" class="btn btn-light">
        Cancel
    </a>
</div>
@endsection @section('script') {{--
<script src="{{ asset('js/tagmanager.js') }}"></script>
<script src="{{ asset('js/typeahead.js') }}"></script> --}} {{--
<script type="text/javascript">
    $(document).ready(function () {
        var tagApi = $(".tm-input").tagsManager();


        $(".typeahead").typeahead({
            name: 'tags',
            displayKey: 'name',
            source: function (query, process) {
                return $.get('ajaxpro.php', {
                    query: query
                }, function (data) {
                    data = $.parseJSON(data);
                    return process(data);
                });
            },
            afterSelect: function (item) {
                tagApi.tagsManager("pushTag", item);
            }
        });
    });
</script> --}} @endsection