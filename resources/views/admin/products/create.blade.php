@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css"> @endsection @section('content')

<a href="/admin/musics" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    
</div>
{!! Form::open(['action' => 'Admin\ProductsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="card" style="width: 100%;">
  <div class="card-header">
    Insert Product
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item center text-center">Category</li>
    <li class="list-group-item text-center">Sub Category</li>
    <li class="list-group-item text-center">Product Name</li>
    <li class="list-group-item text-center">Product Company</li>
    <li class="list-group-item text-center">Product Price</li>
    <li class="list-group-item text-center">Product Description</li>
    <li class="list-group-item text-center">Product Product Availability</li>
    <li class="list-group-item text-center">Product Image 1</li>
    <li class="list-group-item text-center">Product Image 2</li>
    <li class="list-group-item text-center">Product Image 3</li>
    <li class="list-group-item text-center">{{Form::submit('Save', ['class' => 'btn btn-primary '])}} {!! Form::close() !!}</li>
  </ul>
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