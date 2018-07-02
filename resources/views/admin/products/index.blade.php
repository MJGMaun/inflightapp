@extends('admin.layouts.app') @section('css') @endsection @section('content')
<link href="{{ asset('css/jquery.dataTables.css') }}" rel="stylesheet">

<a class="btn btn-sm btn-primary" href="/admin/products/create">
    <span data-feather="plus"></span>
    Add Product
</a>
<br>
<br>


<div class="card" style="width: 100%;">
    <div class="card-header">
        Manage Categories
    </div>
    <br>
    <div style="width: 100%; padding-left: -10px; border: 1px;" class="">
        <div class="table-responsive">
            <table id="products-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product Price Before</th>
                        <th>Product Price Token</th>
                        <th>Product Availability</th>
                        <th>Product Category</th>
                        <th>Product Sub Category</th>
                        <th>Product Company</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($products)) 
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td><img height="50px" width="60px" src="/storage/product_images/{{$product->product_image_1}}" /><span class="d-none">{{$product->cover_image}}</span></td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->product_price}}</td>
                                    <td>{{$product->product_price_before_discount}}</td>
                                    <td>{{$product->product_price_token}}</td>
                                    <td>{{$product->product_availability}}</td>
                                    <td>{{$product->subcategory->category->product_category_name}}</td>
                                    <td>{{$product->subcategory->product_sub_category_name}}</td>
                                    <td>{{$product->product_company}}</td>
                                    <td>
                                        <div class="row">
                                        &nbsp;&nbsp;<a href="/admin/products/{{$product->id}}/edit" class="btn btn-sm btn-primary" ><span data-feather="edit"></span></a>
                                        &nbsp; {!!Form::open(['action' => ['Admin\ProductsController@destroy', $product->id], 'method'
                                            => 'POST', 'class' => 'float-right'])!!} {{Form::hidden('_method', 'DELETE')}} {{Form::button('<span data-feather="trash"></span>',['type' => 'submit','class'
                                            => 'btn btn-sm btn-danger delete-music'])}} {!!Form::close()!!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <p>No Categories Found</p>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection @section('script') {!!Html::script('js/datatable/dataTables.buttons.min.js')!!} {!!Html::script('js/datatable/buttons.flash.min.js')!!}
{!!Html::script('js/datatable/jszip.min.js')!!} {!!Html::script('js/datatable/pdfmake.min.js')!!} {!!Html::script('js/datatable/vfs_fonts.js')!!}
{!!Html::script('js/datatable/buttons.html5.min.js')!!} {!!Html::script('js/datatable/buttons.print.min.js')!!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#products-table').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

    });
</script>
@endsection