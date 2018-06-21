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
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('category', 'Category', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                <select class="form-control categories" name="category" id="category">
                    <option disabled selected="true">Select Category..</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{ $category->product_category_name }}</option>
                        @endforeach
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('subCategory', 'Sub Category', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                <select class="form-control" name="subCategory" id="subCategory">
                    <option disabled selected="true">Select Sub Category..</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productName', 'Product Name', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::text('productName', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Name'])}}
            </div>
        </div>
    </li>
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

<script type="text/javascript">
    //DROPDOWN DEPENDENT
    $(document).on('change','.categories',function(){
            console.log("hmm it changed");

            var category_id=$(this).val();
            console.log(category_id);

            var op=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('json_sub_categories')!!}',
                data:{'id':category_id},
                dataType: 'json',
                success:function(data){
                    console.log('success');
                    console.log(data);

                    dataLength = Object.keys(data).length;

                    console.log("Length"+dataLength);
                    op+='<option selected disabled>Choose Sub Category</option>';
                    op+='<option value="0">None</option>';// FOR NEW ALBUM OPTION APPEND ALBUM NAME
                    for(var i=0;i<dataLength;i++){
                    op+='<option value="'+data[i].id+'">'+data[i].product_sub_category_name+'</option>';
                   }
                    // FOR NEW ALBUM OPTION APPEND ALBUM NAME
                   $(document).find('#subCategory').html(" ");
                   $(document).find('#subCategory').append(op);
                },
                error:function(){
                    console.log('error');
                }
            });
        });
</script>
@endsection