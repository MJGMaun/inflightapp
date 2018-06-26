@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css"> @endsection @section('content')

<a href="/admin/musics" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h4>New Season &amp; Episodes</h4>
</div>

{!! Form::open(['action' => 'Admin\SeriesController@storeSeason', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'form'])
!!}
<div class="row">
    <div class="col-md-6 col-sm-6 add-series">
        {{Form::label('series', 'Series')}}
        <select class="form-control series" name="series" id="series">
            <option disabled selected="true">Select Series..</option>
            {{--
            <option name="new_artist" value="new_artist">New Artist..</option> --}} @foreach ($series as $serie)
            <option value="{{$serie->id}}">{{ $serie->title}}</option>
            @endforeach
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6 col-sm-6 add-series">
        {{Form::label('season', 'Season')}} 
        @if(count($serie->episodes)!=0)
            $episodeCount = count($serie->season);
            {{Form::text('season', $episodeCount, ['class' => 'form-control', 'readonly' => 'true'])}}
        @else
            {{Form::text('season', '1', ['class' => 'form-control season', 'readonly' => 'true'])}}
        @endif 
        <br>
        <div class="image-containe pull-left">
            <div class="image ">
                {{Form::label('cover_image', 'Season Cover Image')}}
                <br>{{Form::file('cover_image')}}
            </div>
        </div>
        <div class="pull-right">
            <br>
            <a class="btn btn-primary add_episode" title="Add Album">
                <span data-feather="plus"></span>
            </a>
            <a class="btn btn-danger remove_episode" title="Remove Album">
                <span data-feather="minus"></span>
            </a>
        </div>

    </div>
    <div id="episode" class="col-md-5 col-sm-5">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                {{Form::label('episodes[]', 'Episode Title')}}
                <small> (Click + to add episode)</small>
                {{Form::text('episodes[]', '', ['class' => 'form-control episodes', 'placeholder' => 'Episode Title'])}}
            </div>
            <div class="col-md-4 col-sm-4">
                {{Form::label('episodeNumbers[]', 'Episode Number')}}
                {{Form::number('episodeNumbers[]', '', ['class' => 'form-control episodes', 'placeholder' => 'Episode #', 'min' => '0'])}}
            </div>
        </div>
        <br>
        <div class="row">
            <div class="video-container col-md-6 col-sm-6">
                <div class="video">
                    {{Form::label('episode_videos', 'Episode Video')}}
                    <br>{{Form::file('episode_videos[]')}}
                </div>
            </div>
        </div>
        <hr>
        <br>
    </div>
</div>
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-success save'])}} {!! Form::close() !!}
    <a href="/admin/musics/" class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script')
<script type="text/javascript">

     //DROPDOWN DEPENDENT
    $(document).on('change','.series',function(){
            console.log("hmm it changed");

            var series_id=$(this).val();
            console.log(series_id);

            var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('json_seasons')!!}',
                data:{'id':series_id},
                dataType: 'json',
                success:function(data){
                    console.log('success');
                    console.log(data);
                    var newCountSeason = data + 1;
                   $(document).find('.season').val(newCountSeason);
                },
                error:function(){
                    console.log('error');
                }
            });
        });

    if (!$('.episodes').val()) {
            $('.save').hide();
        } 
    $('.episodes').keyup(function () {
        if (!$('.episodes').val()) {
            $('.save').hide();
        } else {
            console.log("Hey");

            $('.save').show();
        }
    });
    $('a.add_episode').click(function (e) {
        e.preventDefault();
            $('#episode').append('<div class="input"><div class="row"><div class="col-md-8 col-sm-8">{{Form::label('episodes[]', 'Episode Title')}}<small> (Click + to add episode)</small>{{Form::text('episodes[]', '', ['class' => 'form-control episodes', 'placeholder' => 'Episode Title'])}}</div><div class="col-md-4 col-sm-4">{{Form::label('episodeNumbers[]', 'Episode Number')}}{{Form::number('episodeNumbers[]', '', ['class' => 'form-control episodes', 'placeholder' => 'Episode #', 'min' => '0'])}}</div></div><br><div class="row"><div class="video-container col-md-6 col-sm-6"><div class="video">{{Form::label('episode_videos', 'Episode Video')}}<br>{{Form::file('episode_videos[]')}}</div></div></div><hr><br></div>');
    });
    $('a.remove_episode').click(function (e) {
        e.preventDefault();
        if ($('#episode .input').length >= 1) {
            $('#episode').children().last().remove();
        }
    });
    //DISABLE FORM SUBMIT USING ENTER
    $('#form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
        });
</script>
@endsection