@extends('admin.layouts.app') @section('css')
@endsection @section('content')

<a href="javascript:history.go(-1)" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">New Movie</h1>
</div>

{!! Form::open(['action' => 'Admin\MoviesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-5 col-sm-5">
        {{Form::label('title', 'Title')}} {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="col-md-3 col-sm-3">    
        {{Form::label('category', 'Category')}} 
        {{Form::select('category', $categories, null, ['class' => 'form-control category', 'placeholder' => 'Select a category...'])}}
    </div>
    <div class="col-md-2 col-sm-2">
        {{Form::label('ewallet_price', 'E-Wallet Price')}} {{Form::number('ewallet_price', '', ['class' => 'form-control ewallet-price', 'placeholder' => 'Enter E-Wallet Price'])}}
    </div>
    <div class="col-md-2 col-sm-2">
        {{Form::label('token_price', 'Token Price')}} {{Form::number('token_price', '', ['class' => 'form-control token-price', 'placeholder' => 'Enter Token Price'])}}
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-5 col-sm-5">
        {{Form::label('cast', 'Casts')}} {{Form::text('cast', '', ['class' => 'form-control', 'placeholder' => 'Mikhaela Maun, Regina Lopez, Joyce Feliciano, Jessica Gomez'])}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('running_time', 'Running Time')}}
        {{Form::number('running_time', '', ['class' => 'form-control', 'placeholder' => 'Enter movie time (minutes)'])}}
    </div>
    <div class="col-md-2 col-sm-2">    
        {{Form::label('release_date', 'Release Date')}} {{Form::date('release_date', null, ['class' => 'form-control'])}}
    </div>
    <div class="col-md-2 col-sm-2">
        {{Form::label('language', 'Language')}} {{Form::select('language', ['English' => 'English', 'Chinese' => 'Chinese'], null,
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
                        {{Form::checkbox('genres[]', $genre->name)}}&nbsp;{{$genre->name}} 
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
    {{Form::label('movie_description', 'Movie Description')}} {{Form::textarea('movie_description', '', ['class' => 'form-control',
    'placeholder' => 'Enter movie description here'])}}
</div>
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-success '])}} {!! Form::close() !!}
    <a class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script')
<script type="text/javascript">
    //DROPDOWN DEPENDENT
    $(document).on('change','.category',function(){
            console.log("hmm its change");

            var category_id=$(this).val();
            console.log(category_id);

            $.ajax({
                type:'get',
                url:'{!!URL::to('json_category_price')!!}',
                data:{'id':category_id},
                dataType: 'json',
                success:function(data){
                    console.log('success');
                    console.log(data);
                     
                    var ewallet = data.ewallet;
                    var token = data.token;
                    
                    
                    // FOR NEW ALBUM OPTION APPEND ALBUM NAME
                   $(document).find('.ewallet-price').val(ewallet);
                   $(document).find('.token-price').val(token);
                },
                error:function(){
                    console.log('error');
                }
            });
        });
</script>
@endsection