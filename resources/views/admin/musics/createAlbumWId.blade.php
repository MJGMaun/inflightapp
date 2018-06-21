@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css"> @endsection @section('content')

<a href="/admin/musics/{{$artist->id}}/editArtist" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">New Album</h1>
</div>

{!! Form::open(['action' => 'Admin\MusicsController@storeArtist', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6 add-artists">
        {{Form::label('artists', 'Artist')}} 
        <select class="form-control artists" name="artists" id="artists">
                  <option value="{{$artist->id}}">{{ $artist->artist_name }}</option>
        </select>
    </div>
    <div id="album" class="col-md-4 col-sm-4">
        {{Form::label('albums[]', 'Album Name')}} <small> (Click + to add album)</small>
        {{Form::text('albums[]', '', ['class' => 'form-control', 'placeholder' => 'Album Name'])}}
        <br>{{Form::file('cover_image')}}
        <hr>
    </div>
    <div class="col-md-2 col-sm-2">
        <a class="btn btn-sm btn-primary add_album" title="Add Album">
            <span data-feather="plus"></span>
        </a>
        <a class="btn btn-sm btn-danger remove_album" title="Remove Album">
            <span data-feather="minus"></span>
        </a>
    </div>
</div>
<br>
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-success '])}} {!! Form::close() !!}
    <a href="/admin/musics/" class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script')
<script type="text/javascript">
        
        $('a.add_album').click(function(e) {
            e.preventDefault();
            if ($('#album input').length < 5) {
                $('#album').append('<div class="input">{{Form::text('albums[]', '', ['class' => 'form-control', 'placeholder' => 'Album Name'])}}<br>{{Form::label('cover_image', 'Cover Image')}}<br>{{Form::file('cover_image')}}<hr><br></div>');
            }
        });
        $('a.remove_album').click(function (e) {
            e.preventDefault();
            if ($('#album .input').length >= 1) {
                $('#album').children().last().remove();
            }
        });

        // FOR NEW ALBUM OPTION APPEND ALBUM NAME
        $('select[name="artists"]').change(function(){
            
            if ($(this).val() == "new_artist"){
                $(".add-artists").append("<div><br><input name='artists' class='field form-control' type='text' placeholder='Artist Name'/><label class='remove float-right'>Remove</label></div>");
                $('select[name="artists"]').attr("disabled","disabled");
                $('input[name="albums[]"]').attr("disabled","disabled");
                $('a.add_album, a.remove_album ').hide();
                $('option[name="new_artist"]').remove();
            }     
        });

        $(".add-artists").on("click", ".remove", function () {
        //  var val = $(this).parent().find("input").val();         
         $('select[name="artists"]').prepend("<option name='new_artist' value='new_artist'>New Artist..</option>");
         $('select[name="artists"]').removeAttr('disabled');
         $('input[name="albums[]"]').removeAttr('disabled');
         $('a.add_album, a.remove_album').show();
         $(this).parent().remove();
     });

</script>
@endsection