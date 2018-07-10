@extends('admin.layouts.app') @section('css')
@endsection @section('content')

<a href="/admin/musics" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">New Artists &amp; Albums</h1>
</div>

{!! Form::open(['action' => 'Admin\MusicsController@storeArtist', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6 col-sm-6 add-artists">
        {{Form::label('artists', 'Artist')}} 
        <select class="form-control artists" name="artists" id="artists">
              <option disabled selected="true">Select Artist..</option>
              <option name="new_artist" value="new_artist">New Artist..</option>
                @foreach ($artists as $artist)
                  <option value="{{$artist->id}}">{{ $artist->artist_name }}</option>
                @endforeach
        </select>
    </div>
    <div id="album" class="col-md-4 col-sm-4">
        {{Form::label('albums[]', 'Album Name')}} <small> (Click + to add album)</small>
        {{Form::text('albums[]', '', ['class' => 'form-control album', 'placeholder' => 'Album Name'])}}<br>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                {{Form::label('categories[]', 'Category')}} {{Form::select('categories[]', ['1' => 'Top Albums of The Month','2' => 'New Album Released', '3' => 'Popular Album', '0' => 'None'], null,
        ['class' => 'form-control', 'placeholder' => 'Select a category...'])}}
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="image-container">
                    <div class="image">
                        {{Form::label('cover_image', 'Cover Image')}}<br>{{Form::file('cover_image[]')}}
                    </div>
                </div>
            </div>
        </div>
        <hr><br>
    </div>
    <div class="col-md-2 col-sm-2"><br>
        <a class="btn btn-primary add_album" title="Add Album">
            <span data-feather="plus"></span>
        </a>
        <a class="btn btn-danger remove_album" title="Remove Album">
            <span data-feather="minus"></span>
        </a>
    </div>
</div>
<br>
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-success save'])}} {!! Form::close() !!}
    <a href="/admin/musics/" class="btn btn-light ">
        Cancel
    </a>
</div>

@endsection @section('script')
<script type="text/javascript">
        if(!$('.album').val()){
                $('.save').hide();
            }
        $('.album').keyup(function(){
            if(!$('.album').val()){
                $('.save').hide();
            }
            else {
                console.log("Hey");
                
                $('.save').show();
            }
        });
        $('a.add_album').click(function(e) {
            e.preventDefault();
            if ($('#album input').length < 5) {
                $('#album').append('<div class="input">{{Form::text('albums[]', '', ['class' => 'form-control album', 'placeholder' => 'Album Name'])}}<br><div class="row"><div class="col-md-6 col-sm-6">{{Form::label('categories[]', 'Category')}} {{Form::select('categories[]', ['1' => 'Top Albums of The Month','2' => 'New Album Released', '3' => 'Popular Album', '0' => 'None'], null, ['class' => 'form-control', 'placeholder' => 'Select a category...'])}}</div><div class="col-md-6 col-sm-6"><div class="image-container"><div class="image">{{Form::label('cover_image[]', 'Cover Image')}}<br>{{Form::file('cover_image[]')}}</div></div></div></div><hr><br></div>');
            }
        });
        $('a.remove_album').click(function (e) {
            e.preventDefault();
            if ($('#album .input').length >= 1) {
                $('#album').children().last().remove();
            }
        });

        // FOR NEW ARTIST APPEND ARTIST INPUT
        $('select[name="artists"]').change(function(){
            $('.save').show();
            
            if ($(this).val() == "new_artist"){
                $(".add-artists").append("<div><br><input name='new_artist_name' class='field form-control' type='text' placeholder='Artist Name'/><label class='remove float-right'>Remove</label></div>");
                $('select[name="artists"]').attr("disabled","disabled");
                $('input[name="albums[]"]').attr("disabled","disabled");
                $('select[name="categories[]"]').attr("disabled","disabled");
                $('a.add_album, a.remove_album ').hide();
                $('a.add_album, a.remove_album ').hide();
                $('.image').remove();
                $('option[name="new_artist"]').remove();
            }     
        });

        $(".add-artists").on("click", ".remove", function () {
            $('.save').hide();
        //  var val = $(this).parent().find("input").val();         
         $('select[name="artists"]').append("<option name='new_artist' value='new_artist'>New Artist..</option>");
         $('.image-container').append('<div class="image">{{Form::label('cover_image', 'Cover Image')}}<br>{{Form::file('cover_image')}}</div>');
         $('select[name="artists"] option').prop('selected', function() {
             return this.defaultSelected;
         });
         $('select[name="artists"]').removeAttr('disabled');
         $('input[name="albums[]"]').removeAttr('disabled');
         $('select[name="categories[]"]').removeAttr('disabled');
         $('a.add_album, a.remove_album').show();
         $(this).parent().remove();
     });

</script>
@endsection