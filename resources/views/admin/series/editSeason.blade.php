@extends('admin.layouts.app') @section('css')
@endsection @section('content')

<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
    <a href="/admin/series">Series</a> &nbsp; <span data-feather="chevron-right"></span> &nbsp;{{$serie->title}}
</div>

{!! Form::open(['action' => ['Admin\SeriesController@updateSeason', $season->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'form'])
!!}
<div class="row">
    <div class="col-md-6 col-sm-6 add-series">
        {{Form::label('series', 'Series')}}
        <select class="form-control series" name="series" id="series">
                <option selected="true" value="{{$serie->id}}">{{ $serie->title}}</option>
        </select>
    </div>
    <div class="col-md-3 col-sm-3 add-series">
        <a class="btn btn-primary add_episode" title="Add Album">
                <span data-feather="plus"></span>
            </a>
            <a class="btn btn-danger remove_episode" title="Remove Album">
                <span data-feather="minus"></span>
            </a>

    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6 col-sm-6 add-series">
        {{Form::label('season', 'Season')}} 
            {{Form::text('season', $season->season_number, ['class' => 'form-control season', 'readonly' => 'true'])}}
        <br>
        <div class="image-containe pull-left">
            {{Form::label('seasonimage', 'Season Cover Image')}}<br>
            <img height="100px" width="110px" src="/storage/series_cover_images/{{$season->seriescoverimage->cover_image}}" />
        </div>
        <div class="pull-right">
            <div class="image ">
                {{Form::label('', '')}}
                <br>{{Form::file('cover_image')}}
            </div>
        </div>

    </div>
    <div id="episode" class="col-md-5 col-sm-5">
        @foreach($season->episodes as $episode)
            <div class="row">
            <div class="col-md-8 col-sm-8">
                {{Form::label('episodes[]', 'Episode Title')}}
                <small> (Click + to add episode)</small>
                {{Form::text('episode_ids[]', $episode->id, ['class' => 'form-control d-none', 'placeholder' => 'Episode Title', 'readonly' => 'true'])}}
                {{Form::text('episodes[]', $episode->title, ['class' => 'form-control episodes', 'placeholder' => 'Episode Title'])}}
            </div>
            <div class="col-md-4 col-sm-4">
                {{Form::label('episodeNumbers[]', 'Episode Number')}}
                {{Form::number('episodeNumbers[]',  $episode->episode_number, ['class' => 'form-control episodes', 'placeholder' => 'Episode #', 'min' => '0'])}}
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
        @endforeach
    </div>
<div class="form-group"><br>
    {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Save', ['class' => 'btn btn-success'])}}
    {!! Form::close() !!}
    <a class="btn btn-light ">
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