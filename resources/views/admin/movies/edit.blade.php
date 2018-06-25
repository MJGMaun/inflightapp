@extends('admin.layouts.app') {{-- @section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css"> @endsection --}} @section('content')
<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
    <a href="/admin/movies">Movies</a> &nbsp; <span data-feather="chevron-right"></span> &nbsp;{{$movie->title}}
</div>

{!! Form::open(['action' => ['Admin\MoviesController@update', $movie->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'])
!!}
<div class="row">
    <div class="col">
        {{Form::label('title', 'Title')}} {{Form::text('title', $movie->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="col">
        {{Form::label('language', 'Language')}} {{Form::select('language', ['English' => 'English', 'Chinese' => 'Chinese'], $movie->language, ['class' => 'form-control'])}}
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        {{Form::label('running_time', 'Running Time')}} {{ Form::time('running_time', $movie->running_time, ['class' => 'form-control without_ampm', 'step' => '1']) }}
    </div>
    <div class="col">
        {{Form::label('release_date', 'Release Date')}} {{Form::date('release_date', \Carbon\Carbon::now(), ['class' => 'form-control'])}}
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        {{Form::label('cast', 'Casts')}} {{Form::text('cast', $movie->cast, ['class' => 'form-control', 'placeholder' => 'Mikhaela Maun, Regina Lopez, Joyce Feliciano, Jessica Gomez'])}}
    </div>
    <div class="col">
        <div class="card card-body bg-light">
            {{Form::label('genre', 'Genre')}}
            <div class="row">
                {{-- @foreach($genres as $genre) --}} @foreach($genres as $genre)
                <div class="col-md-3 col-sm-3">
                    @if(in_array($genre->name, $movie_genres)) {{Form::checkbox('genres[]', $genre->name, ['checked' => 'checked'])}} &nbsp;{{$genre->name}}
                    @else {{Form::checkbox('genres[]', $genre->name)}} &nbsp;{{$genre->name}} @endif
                </div>
                @endforeach
            </div>
        </div>
        <br>
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        {{Form::label('cover_image', 'Cover Image')}}
        <br>{{$movie->cover_image}}<br><br>{{Form::file('cover_image')}}
    </div>
    <div class="col">
        {{Form::label('movie_video', 'Movie')}}
        <br>{{$movie->movie_video}}<br><br>{{Form::file('movie_video')}}
    </div>
</div>
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