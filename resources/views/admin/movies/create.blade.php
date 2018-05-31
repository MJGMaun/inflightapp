@extends('admin.layouts.app')
@section('content')

        <button class="btn btn-sm btn-primary">
                <span data-feather="arrow-left"></span>
                Back
        </button><br><br>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Upload New Movie</h1>
        </div>

        {!! Form::open(['action' => 'Admin\MoviesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="row">
            <div class="col">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
            </div>
            <div class="col">
                {{Form::label('language', 'Language')}}
                {{Form::select('language', ['English' => 'English', 'Chinese' => 'Chinese'], null, ['class' => 'form-control', 'placeholder' => 'Select a language...'])}}
            </div>
        </div><br>
        <div class="row">
            <div class="col">
                {{Form::label('running_time', 'Running Time')}}
                {{Form::text('running_time', '', ['class' => 'form-control', 'placeholder' => 'Enter movie running time'])}}
            </div>
            <div class="col">
                {{Form::label('release_date', 'Release Date')}}
                {{Form::date('release_date', \Carbon\Carbon::now(), ['class' => 'form-control'])}}
            </div>
        </div><br>
        {{-- <div class="row">
            <div class="col">
                {{Form::label('casts', 'Casts')}}
                {{Form::text('casts', '', ['class' => 'form-control typeahead tm-input form-control tm-input-info', 'placeholder' => 'Casts'])}}
            </div>
            <div class="col">
                {{Form::label('genre', 'Genre')}}
                {{Form::text('genre', '', ['class' => 'form-control typeahead tm-input form-control tm-input-info', 'placeholder' => 'Genre'])}}
            </div>
        </div><br> --}}
        <div class="row">
            <div class="col">
                {{Form::label('cover_image', 'Cover Image')}}<br>
                {{Form::file('cover_image')}}
            </div>
            <div class="col">
                {{Form::label('movie_video', 'Movie')}}<br>
                {{Form::file('movie_video')}}
            </div>
        </div><br>
        <div class="form-group">
            {{Form::label('movie_description', 'Movie Description')}}
            {{Form::textarea('movie_description', '', ['class' => 'form-control', 'placeholder' => 'Enter movie description here'])}}
        </div>
        <div class="form-group">
            {{Form::submit('Save', ['class' => 'btn btn-primary '])}}
        {!! Form::close() !!}
            <a class="btn btn-light ">
                    Cancel
            </a>
        </div>
        
@endsection
@section('page-script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
	  $(document).ready(function() {
    var tagApi = $(".tm-input").tagsManager();


    jQuery(".typeahead").typeahead({
      name: 'tags',
      displayKey: 'name',
      source: function (query, process) {
        return $.get('ajaxpro.php', { query: query }, function (data) {
          data = $.parseJSON(data);
          return process(data);
        });
      },
      afterSelect :function (item){
        tagApi.tagsManager("pushTag", item);
      }
    });
  });
</script>
@stop