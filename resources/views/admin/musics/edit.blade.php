@extends('admin.layouts.app') @section('css')
@endsection @section('content')

<a href="javascript:history.go(-1)" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">New Song</h1>
</div>

{!! Form::open(['action' => ['Admin\MusicsController@update', $music->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6">
        {{Form::label('title', 'Title')}} {{Form::text('title', $music->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{-- {{Form::label('artist', 'Artist')}} 
        <select class="form-control artists" name="artists" id="artists">
              <option disabled selected="true">Select Artist..</option>
                @foreach ($artists as $artist)
                  <option value="{{$artist->id}}">{{ $artist->artist_name }}</option>
                @endforeach
        </select> --}}
    </div>
    <div class="col-md-3 col-sm-3 add-albums">
        {{-- {{Form::label('albums', 'Album')}}
        <select class="form-control" name="albums" id="albums">
              <option disabled selected="true">Select Albums..</option>
        </select> --}}
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-6 col-sm-6">
            {{Form::label('genres', 'Genre')}}
        <div class="card card-body bg-light">
            <div class="row">
                @foreach($genres as $genre)
                <div class="col-md-3 col-sm-3">
                    @if($music->genre == $genre ) {{Form::radio('genre', $music->genre, ['checked' => 'checked'])}} &nbsp;{{$music->genre}}
                    @else {{Form::radio('genre', $genre)}} &nbsp;{{$genre}} @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('cover_image', 'Cover Image')}}
        <br> {{Form::file('cover_image')}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{Form::label('music_song', 'Song')}}
        <br> {{Form::file('music_song')}}
    </div>
</div><br>
<div class="form-group">
    {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-success'])}}
    {!! Form::close() !!}
    <a class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

{{-- <script src="{{ asset('js/tagmanager.js') }}"></script>
<script src="{{ asset('js/typeahead.js') }}"></script> --}}
<script type="text/javascript">
    $(document).on('change','.artists',function(){
            console.log("hmm its change");

            var artist_id=$(this).val();
            console.log(artist_id);

            var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('json_albums')!!}',
                data:{'id':artist_id},
                dataType: 'json',
                success:function(data){
                    console.log('success');
                    console.log(data);

                    dataLength = Object.keys(data).length;

                    console.log("Length"+dataLength);
                    op+='<option selected disabled>Choose Album</option>';
                    op+='<option name="albums" value="1">Single (No Album)</option>';// FOR NEW ALBUM OPTION APPEND ALBUM NAME
                    for(var i=0;i<dataLength;i++){
                    op+='<option value="'+data[i].id+'">'+data[i].album_name+'</option>';
                   }
                    op+='<option name="new_album" value="New Album..">New Album..</option>';
                    // FOR NEW ALBUM OPTION APPEND ALBUM NAME
                   $(document).find('#albums').html(" ");
                   $(document).find('#albums').append(op);
                },
                error:function(){
                    console.log('error');
                }
            });
        });
    // FOR NEW ALBUM OPTION APPEND ALBUM NAME
        $('select[name="albums"]').change(function(){
            
            if ($(this).val() == "New Album.."){
                $(".add-albums").append("<div><br><input name='albums' class='field form-control' type='text' placeholder='" + $(this).val() + "'/><label class='remove float-right'>Remove</label></div>");
                $('select[name="albums"]').attr("disabled","disabled");
                $('option[name="new_album"]').remove();
            }     
        });

        $(".add-albums").on("click", ".remove", function () {
        //  var val = $(this).parent().find("input").val();         
         $('select[name="albums"]').append("<option name='new_album' value='New Album..'>New Album..</option>");
         $('select[name="albums"]').removeAttr('disabled');
         $(this).parent().remove();
     });
</script>
@endsection