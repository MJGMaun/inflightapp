@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css"> @endsection @section('content')

<a href="/admin/musics" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">New Album</h1>
</div>

{!! Form::open(['action' => 'Admin\MoviesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6">
        {{Form::label('title', 'Album Name')}} {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Album Name'])}}
    </div>
    <div class="col">
        {{Form::label('artist', 'Artist')}} {{Form::select('artist', ['English' => 'English', 'Chinese' => 'Chinese'], null, ['class'
        => 'form-control', 'placeholder' => 'Select a language...'])}}
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        {{Form::label('cover_image', 'Cover Image')}}
        <br> {{Form::file('cover_image')}}<br><br>
    </div>
    <div class="col">
        {{Form::label('album_songs[]', 'Songs')}} <small>(Select Multiple Songs)</small>
        <br> {{Form::file('album_songs[]', ['multiple' => 'multiple'])}}
    </div>
</div>
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-primary '])}} {!! Form::close() !!}
    <a href="/admin/musics/" class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script')
<script type="text/javascript">
    $(function() {
        $('a.pl').click(function(e) {
            e.preventDefault();
            $('#phone').append('<input type="text" value="Phone">');
        });
        $('a.mi').click(function (e) {
            e.preventDefault();
            if ($('#phone input').length > 1) {
                $('#phone').children().last().remove();
            }
        });
    });
    </script>
@endsection