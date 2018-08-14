@extends('admin.layouts.app') @section('css') @endsection @section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    
</div>
{!! Form::open(['action' => 'Admin\ProductsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="card" style="width: 100%;">
  <div class="card-header">
    Insert Product
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productCategory', 'Category', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                <select class="form-control categories" name="productCategory" id="category">
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
            {{Form::label('productSubCategory', 'Sub Category', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                <select class="form-control" name="productSubCategory" id="subCategory">
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
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productCompany', 'Product Company', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::text('productCompany', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Company'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productPriceBefore', 'Product Price Before', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::number('productPriceBefore', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Price Before'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productPriceAfter', 'Product Price After (Selling Price)', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::number('productPriceAfter', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Price After'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productPriceToken', 'Product Price Token', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::number('productPriceToken', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Price Token'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productDescription', 'Product Description', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::textarea('productDescription', '', ['class' => 'form-control', 'placeholder' => 'Enter Product Description'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productImage1', 'Product Image 1', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::file('productImage1')}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productImage2', 'Product Image 2', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::file('productImage2')}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productImage3', 'Product Image 3', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::file('productImage3')}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productImage4', 'Product Image 4', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::file('productImage4')}}
            </div>
        </div>
    </li>
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
                    dataLength = Object.keys(data).length;

                    op+='<option selected disabled>Choose Sub Category</option>';
                    for(var i=0;i<dataLength;i++){
                    op+='<option value="'+data[i].id+'">'+data[i].product_sub_category_name+'</option>';
                   }
                   if(dataLength == 0){
                        op+='<option disabled="disabled" class="font-italic text-muted">No Sub Category found</option>';// FOR NEW ALBUM OPTION APPEND ALBUM NAME
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