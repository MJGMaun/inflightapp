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

{!! Form::open(['action' => 'Admin\MoviesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6">
        {{Form::label('name', 'Artist Name')}} {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Artist Name'])}}
    </div>
    <div id="album" class="col-md-4 col-sm-4">
        {{Form::label('albumname', 'Album Name')}} {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Artist Name'])}}
    </div>
    <div class="col-md-2 col-sm-2"><br>
        <a class="btn btn-light add_album">
            Add Album
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
            $('#album').append(' {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Artist Name'])}}');
        });
        $('a.add_album').click(function (e) {
            e.preventDefault();
            if ($('#album input').length > 1) {
                $('#album').children().last().remove();
            }
        });
    });
    </script>
@endsection