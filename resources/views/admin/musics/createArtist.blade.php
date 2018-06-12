@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css"> @endsection @section('content')

<a href="/admin/musics" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">New Artist</h1>
</div>

{!! Form::open(['action' => 'Admin\MusicsController@storeArtist', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6">
        {{Form::label('artist_name', 'Artist Name')}} {{Form::text('artist_name', '', ['class' => 'form-control', 'placeholder' => 'Artist Name'])}}
    </div>
    <div id="album" class="col-md-4 col-sm-4">
        {{Form::label('album_name', 'Album Name')}}
    </div>
    <div class="col-md-2 col-sm-2"><br>
        <a class="btn btn-primary add_album" title="Add Album">
            <span data-feather="plus"></span>
        </a>
        <a class="btn btn-danger remove_album" title="Remove Album">
            <span data-feather="minus"></span>
        </a>
    </div>
</div>
<br>
{{-- <div class="row">
    <div class="col">
        {{Form::label('cover_image', 'Cover Image')}}
        <br> {{Form::file('cover_image')}}<br><br>
    </div>
    <div class="col">
        {{Form::label('album_songs[]', 'Songs')}}
        <br> {{Form::file('album_songs[]', ['multiple' => 'multiple'])}}
    </div>
</div> --}}
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-primary '])}} {!! Form::close() !!}
    <a href="/admin/musics/" class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('a.add_album').click(function(e) {
            e.preventDefault();
            if ($('#album input').length < 1) {
                $('#album').append('<br>{{Form::text('album_name', '', ['class' => 'form-control', 'placeholder' => 'Album Name'])}}');
            }
        });
        $('a.remove_album').click(function (e) {
            e.preventDefault();
            if ($('#album input').length >= 1) {
                $('#album').children().last().remove();
            }
        });
    });
    </script>
@endsection




{{-- @endsection @section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('a.add_album').click(function(e) {
            e.preventDefault();
            $('#album').append('<div class="new_album"><br>{{Form::text('album_names[]', '', ['class' => 'form-control', 'placeholder' => 'Album Name'])}}{{Form::label('cover_image[]', 'Cover Image')}}<br>{{Form::file('cover_image[]')}}<br><br></div>');
            });
        $('a.remove_album').click(function (e) {
            e.preventDefault();
            if ($('#album .new_album').length >= 1) {
                $('#album').children().last().remove();
            }
        });
    });
    </script>
@endsection --}}