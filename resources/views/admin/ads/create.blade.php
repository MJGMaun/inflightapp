@extends('admin.layouts.app') @section('css')

<style>
    .without_ampm::-webkit-datetime-edit-ampm-field {
   display: none;
 }
 input[type=time]::-webkit-clear-button {
   -webkit-appearance: none;
   -moz-appearance: none;
   -o-appearance: none;
   -ms-appearance:none;
   appearance: none;
   margin: -10px; 
 }
</style>
@endsection @section('content')

<a href="javascript:history.go(-1)" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">New Advertisement</h1>
</div>

{!! Form::open(['action' => 'Admin\AdsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6">
        {{Form::label('name', 'Name')}} {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Ad Title'])}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('roll', 'Roll')}} {{Form::select('roll', ['pre-roll' => 'Pre Roll', 'mid-roll' => 'Mid Roll', 'post-roll' => 'Post Roll'], null,
        ['class' => 'form-control', 'placeholder' => 'Select ad position...'])}}
    </div>
    <div class="col-md-3 col-sm-3">   
        {{Form::label('time', 'Roll')}} 
        {{Form::time('time', '01:00:00', ['class' => 'form-control without_ampm', 'step' => '1'])}}         
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
        {{Form::label('ad_video', 'Ad Video')}}
        <br> {{Form::file('ad_video')}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('playsNeeded', 'Plays Needed')}} {{Form::number('playsNeeded', '', ['class' => 'form-control', 'min' => '0', 'placeholder' => 'Enter Value'])}}
    </div>
</div>
<br>    
<br>
<br>
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-success '])}} {!! Form::close() !!}
    <a class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script')
    <script>

        $('input[name="time"]').attr("disabled", "disabled");
    // FOR NEW ARTIST APPEND ARTIST INPUT
        $('select[name="roll"]').change(function(){
            
            if ($(this).val() == "mid-roll"){
                $('input[name="time"]').removeAttr("disabled");
                // $('input[name="minute"]').removeAttr("disabled");
                // $('input[name="second"]').removeAttr("disabled");
            }
            else if ($(this).val() == "pre-roll"){
                $('input[name="time"]').attr("disabled", "disabled");
                // $('input[name="minute"]').attr("disabled", "disabled");
                // $('input[name="second"]').attr("disabled", "disabled");
            }
            else{
                $('input[name="time"]').attr("disabled", "disabled");
                // $('input[name="minute"]').attr("disabled", "disabled");
                // $('input[name="second"]').attr("disabled", "disabled");
            }
        });
        </script>
@endsection