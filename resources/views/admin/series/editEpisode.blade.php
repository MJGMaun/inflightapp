@extends('admin.layouts.app') @section('css')
@endsection @section('content')

<a href="javascript:history.go(-1)" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4>New Season &amp; Episodes</h4>
</div>

{!! Form::open(['action' =>[ 'Admin\SeriesController@updateEpisode', $episode->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'form'])
!!}
<div class="row">
    <div class="col-md-6 col-sm-6 add-series">
        {{Form::label('series', 'Series')}}
        <select class="form-control series" name="series" id="series">
            <option selected="true" value="{{$episode->series->id}}">{{ $episode->series->title}}</option>
            {{-- @foreach ($series as $serie)
            @if($episode->series->title == $serie->title)
                <option selected="true" value="{{$serie->id}}">{{ $serie->title}}</option>
            @else
                <option value="{{$serie->id}}">{{ $serie->title}}</option>
            @endif
            @endforeach --}}
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6 col-sm-6 add-series">
        {{Form::label('season', 'Season')}} 
        {{Form::text('season', $episode->season->season_number, ['class' => 'form-control', 'readonly' => 'true'])}}
        <br>
    </div>
    <div id="episode" class="col-md-5 col-sm-5">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                {{Form::label('episodes[]', 'Episode Title')}}
                <small> (Click + to add episode)</small>
                {{Form::text('episode', $episode->title, ['class' => 'form-control episodes', 'placeholder' => 'Episode Title'])}}
            </div>
            <div class="col-md-4 col-sm-4">
                {{Form::label('episodeNumber', 'Episode Number')}}
                {{Form::number('episodeNumber', $episode->episode_number, ['class' => 'form-control episodes', 'placeholder' => 'Episode #', 'min' => '0', 'readonly'])}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="video-container col-md-6 col-sm-6">
                <div class="video">
                    {{Form::label('episode_video', 'Episode Video')}}
                    <br>{{Form::file('episode_video')}}
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="price-container col-md-6 col-sm-6">
                <div class="price">
                    {{Form::label('priceLevel', 'Price Level')}}
                    {{Form::select('priceLevel', ['10' => '1', '20' => '2', '30' => '3', '40' => '4', '50' => '5'], null,['class' => 'form-control pricelevel', 'placeholder' => 'Select level..'])}}
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                @php
                    $ewallet_price = preg_replace('/[^A-Za-z0-9\-]/', '', $episode->ewallet_price);
                @endphp
                {{Form::label('ewallet_price', 'E-Wallet Price')}} 
                {{Form::number('ewallet_price', $ewallet_price, ['class' => 'form-control ewallet-price', 'placeholder' => 'Enter Episode Price'])}}
            </div>
        </div>
        <hr><br>
    </div>
</div>
<div class="form-group">
    {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Save', ['class' => 'btn btn-success'])}}
    {!! Form::close() !!}
    <a class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script')
<script type="text/javascript">
    //PRICE LEVEL        
    $(document).on('change','.pricelevel',function(){
        var tokenPrice = $(this).val();
        $(this).closest('.row').find('.ewallet-price').val(tokenPrice);
    });
</script>
@endsection