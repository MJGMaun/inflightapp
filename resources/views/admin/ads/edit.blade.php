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

<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
    <a href="/admin/ads">Ads</a> &nbsp; <span data-feather="chevron-right"></span> &nbsp;{{$ad->name}}
</div>

{!! Form::open(['action' => ['Admin\AdsController@update', $ad->id ], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6">
        {{Form::label('name', 'Name')}} {{Form::text('name', $ad->name, ['class' => 'form-control', 'placeholder' => 'Ad Title'])}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('roll', 'Roll')}} {{Form::select('roll', ['pre-roll' => 'Pre Roll', 'mid-roll' => 'Mid Roll', 'post-roll' => 'Post Roll'], $ad->roll,
        ['class' => 'form-control', 'placeholder' => 'Select ad position...'])}}
    </div>
    <div class="col-md-3 col-sm-3">   
        {{Form::label('time', 'Time')}} 
        {{Form::time('time', $ad->time, ['class' => 'form-control without_ampm', 'step' => '1'])}}         
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
        {{Form::label('ad_video', 'Ad Video')}}
        <br> {{Form::file('ad_video')}}
    </div>
    <div class="col-md-2 col-sm-2">
        {{Form::label('playsNeededDrop', 'Plays Needed')}} 
        <select class="form-control playsNeededDrop" name="playsNeededDrop" id="playsNeededDrop">
              <option disabled selected="true">Plays Needed..</option>
                @if ($ad->number_of_plays_needed == $ad->number_of_plays_remaining)
                    <option value="edit-value">Edit Value</option>
                @else
                    <option class="font-italic" disabled>Plays needed cannot be edited..</option>
                @endif
                <option name="add-value" value="add-value">Add Value</option>
        </select>
    </div>
    <div class="col-md-2 col-sm-2">
         @if ($ad->number_of_plays_needed == $ad->number_of_plays_remaining)
        {{Form::label('playsNeeded', 'Value Needed')}} 
        {{Form::number('playsNeeded', $ad->number_of_plays_needed, ['disabled' => 'true', 'class' => 'form-control', 'min' => '0', 'placeholder' => 'Enter Value'])}}
        @endif
    </div>
    <div class="col-md-2 col-sm-2">
        {{Form::label('playsNeededAdd', 'Add Value')}} 
        {{Form::number('playsNeededAdd', '', ['disabled' => 'true', 'class' => 'form-control', 'min' => '0', 'placeholder' => 'Enter Value'])}}
    </div>

</div>
<br>    
<br>
<br>
<div class="form-group">
    {{Form::hidden('_method', 'PUT')}} {{Form::submit('Save', ['class' => 'btn btn-success'])}} {!! Form::close() !!}
    <a class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script')
    <script>

        if($('select[name="roll"]').val() != 'mid-roll'){
            $('input[name="time"]').attr("disabled", "disabled");
        }
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

        $('select[name="playsNeededDrop"]').change(function(){
            
            if ($(this).val() == "edit-value"){
                $('input[name="playsNeeded"]').removeAttr("disabled");
                $('input[name="playsNeededAdd"]').attr("disabled", "disabled");
            }
            else if ($(this).val() == "add-value"){
                $('input[name="playsNeededAdd"]').removeAttr("disabled");
                $('input[name="playsNeeded"]').attr("disabled", "disabled");
            }
            else{
                console.log('None');
            }
        });
        </script>
@endsection