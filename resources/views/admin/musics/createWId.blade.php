@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css"> @endsection @section('content')

<a href="/admin/musics" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">New Song</h1>
</div>

{!! Form::open(['action' => 'Admin\MusicsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6">
        {{Form::label('title', 'Title')}} {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('artist', 'Artist')}} 
        <select class="form-control artists" name="artists" id="artists">
                  <option value="{{$album->artists->id}}">{{ $album->artists->artist_name }}</option>
        </select>
    </div>
    <div class="col-md-3 col-sm-3 add-albums">
        {{Form::label('albums', 'Album')}}
        <select class="form-control" name="albums" id="albums" aria-readonly="true">
              <option value="{{$album->id}}">{{ $album->album_name }}</option>
              @foreach($artist->albums as $album)
                <option value="{{$album->id}}">{{ $album->album_name }}</option>
              @endforeach
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6 col-sm-6">
            {{Form::label('genres', 'Genre')}}
        <div class="card card-body bg-light">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    {{Form::radio('genres', 'OPM')}} OPM
                </div>
                <div class="col-md-3 col-sm-3">
                    {{Form::radio('genres', 'Pop')}} Pop 
                </div>
                <div class="col-md-3 col-sm-3">
                    {{Form::radio('genres', 'R&B')}} R&amp;B
                </div>
                <div class="col-md-3 col-sm-3">
                    {{Form::radio('genres', 'Hip-Hop')}} Hip-Hop
                </div>
                <div class="col-md-3 col-sm-3">
                    {{Form::radio('genres', 'Rock')}} Rock
                </div>
                <div class="col-md-3 col-sm-3">
                    {{Form::radio('genres', 'Jazz')}} Jazz
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('cover_image', 'Cover Image')}}
        <br> {{Form::file('cover_image')}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('music_song', 'Song')}}
        <br> {{Form::file('music_song')}}
    </div>
</div><br>
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-primary '])}} {!! Form::close() !!}
    <a class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@endsection