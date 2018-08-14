@extends('admin.layouts.app') @section('css')
@endsection @section('content')

<a href="/admin/products" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <input type="input" value="{{$product->id}}" disabled hidden id="productID">
</div>
{!! Form::open(['action' => ['Admin\ProductsController@update', $product->id ], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
                        @foreach ($categories as $category)
                            @if($category->id == $product->subcategory->category->id)
                                <option selected="true" value="{{$category->id}}">{{ $category->product_category_name }}</option>
                            @else
                                <option value="{{$category->id}}">{{ $category->product_category_name }}</option>
                            @endif
                        @endforeach
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productSubCategory', 'Sub Category', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                <select class="form-control" name="productSubCategory" id="subCategories">
                     <option value="{{$product->subcategory->id}}" selected="true" id="subCategory">{{$product->subcategory->product_sub_category_name}}</option>
                </select>
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productName', 'Product Name', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::text('productName', $product->product_name, ['class' => 'form-control', 'placeholder' => 'Enter Product Name'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productCompany', 'Product Company', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::text('productCompany', $product->product_company, ['class' => 'form-control', 'placeholder' => 'Enter Product Company'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productPriceBefore', 'Product Price Before', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::number('productPriceBefore', $productPriceBefore, ['class' => 'form-control', 'placeholder' => 'Enter Product Price Before'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productPriceAfter', 'Product Price After (Selling Price)', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::number('productPriceAfter', $productPrice, ['class' => 'form-control', 'placeholder' => 'Enter Product Price After'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productDescription', 'Product Description', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::textarea('productDescription', $product->product_description, ['class' => 'form-control', 'placeholder' => 'Enter Product Description'])}}
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productImage1', 'Product Image 1', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-4">
                {{Form::file('productImage1')}}
            </div>
            <div class="col-sm-3">
                <img height="100px" width="140px" src="/storage/product_images/{{$product->product_image_1}}" />
            </div>
            <div class="col-sm-2">
                <br><span>{{$product->product_image_1}}</span>
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productImage2', 'Product Image 2', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-4">
                {{Form::file('productImage2')}}
            </div>
            <div class="col-sm-3">
                <img height="100px" width="140px" src="/storage/product_images/{{$product->product_image_2}}" />
            </div>
            <div class="col-sm-2">
                <br><span>{{$product->product_image_2}}</span>
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productImage3', 'Product Image 3', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-4">
                {{Form::file('productImage3')}}
            </div>
            <div class="col-sm-3">
                <img height="100px" width="140px" src="/storage/product_images/{{$product->product_image_3}}" />
            </div>
            <div class="col-sm-2">
                <br><span>{{$product->product_image_3}}</span>
            </div>
        </div>
    </li>
    <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('productImage4', 'Product Image 4', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-4">
                {{Form::file('productImage4')}}
            </div>
            <div class="col-sm-3">
                <img height="100px" width="140px" src="/storage/product_images/{{$product->product_image_4}}" />
            </div>
            <div class="col-sm-2">
                <br><span>{{$product->product_image_4}}</span>
            </div>
        </div>
    </li>
    <li class="list-group-item text-center">{{Form::hidden('_method', 'PUT')}} {{Form::submit('Save', ['class' => 'btn btn-success'])}} {!! Form::close() !!}</li>
  </ul>
</div>

@endsection @section('script') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript">
    //DROPDOWN DEPENDENT
    $(document).on('change','.categories',function(){

            console.log("hmm it changed");
            $('#productID').val();
            $('select#subCategories').children('option').remove();
            var category_id=$(this).val();
            var productID=$('#productID').val();
            console.log(productID);

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
                    // op+='<option id="subCategory" value="'+data[i].id+'">'+data[i].product_sub_category_name+'</option>';
                        if(productID == data[i].product_category_id){
                            op+='<option id="subCategory" selected="true" value="'+data[i].id+'">'+data[i].product_sub_category_name+'</option>';
                        }else{
                            op+='<option id="subCategory" value="'+data[i].id+'">'+data[i].product_sub_category_name+'</option>';
                        }
                   }
                    // FOR NEW ALBUM OPTION APPEND ALBUM NAME
                   $(document).find('#subCategories').html(" ");
                   $(document).find('#subCategories').append(op);
                },
                error:function(){
                    console.log('error');
                }
            });
        });
</script>
@endsection