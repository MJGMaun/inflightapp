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

{!! Form::open(['action' => 'Admin\MoviesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6">
        {{Form::label('title', 'Title')}} {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('artist', 'Artist')}} {{Form::select('artist', ['English' => 'English', 'Chinese' => 'Chinese'], null, ['class'
        => 'form-control', 'placeholder' => 'Select a language...'])}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('album', 'Album')}} {{Form::select('album', ['1' => 'Popular Movie','2' => 'Trending Movie', '3' => 'New Release',
        '0' => 'None'], null, ['class' => 'form-control', 'placeholder' => 'Select a category...'])}}
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="card card-body bg-light">
            {{Form::label('genre', 'Genre')}}
            <div class="row">
                {{-- @foreach($genres as $genre)
                <div class="col-md-3 col-sm-3">
                    {{Form::checkbox('genres[]', $genre->name)}}&nbsp;{{$genre->name}}
                </div>
                @endforeach --}}
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('release_date', 'Release Date')}} {{Form::date('release_date', \Carbon\Carbon::now(), ['class' => 'form-control'])}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('cover_image', 'Cover Image')}}
        <br> {{Form::file('cover_image')}}<br><br>
        {{Form::label('music_song', 'Song')}}
        <br> {{Form::file('music_song')}}
    </div>
</div>
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-primary '])}} {!! Form::close() !!}
    <a class="btn btn-light ">
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