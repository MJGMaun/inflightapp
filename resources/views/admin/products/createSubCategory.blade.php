@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}"> @endsection @section('content')
{!! Form::open(['action' => 'Admin\ProductsController@storeSubCategory', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="card" style="width: 100%;">
    <div class="card-header">
        Sub Category
    </div>
    <ul class="list-group list-group-flush">

        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('category', 'Category', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    <select class="form-control artists" name="category" id="category">
                        <option disabled selected="true">Select Category..</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{ $category->product_category_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('subCategoryName', 'Sub Category', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('subCategoryName', '', ['class' => 'form-control', 'placeholder' => 'Enter Sub Category Name'])}}
                </div>
            </div>
        </li>

        <li class="list-group-item text-center">{{Form::submit('Save', ['class' => 'btn btn-success '])}} {!! Form::close() !!}</li>
    </ul>
</div>
<br>
<div class="card" style="width: 100%;">
    <div class="card-header">
        Manage Sub Categories
    </div>
    <br>
    <div style="width: 100%; padding-left: -10px; border: 1px;" class="">
        <div class="table-responsive">
            <table id="categories-table" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($subCategories)) 
                            @foreach($subCategories as $subCategory)
                                 <tr>
                                    <td>{{$subCategory->id}}</td>
                                    <td>{{$subCategory->category->product_category_name}}</td>
                                    <td>{{$subCategory->product_sub_category_name}}</td>
                                    <td>{{$subCategory->created_at}}</td>
                                    <td>{{$subCategory->updated_at}}</td>
                                    <td>
                                        <div class="row">
                                        <a href="/admin/products/{{$subCategory->id}}/editSubCategory" class="btn btn-sm btn-primary" ><span data-feather="edit"></span></a>
                                        &nbsp; {!!Form::open(['action' => ['Admin\ProductsController@destroySubCategory', $subCategory->id], 'method'
                                            => 'POST', 'class' => 'float-right'])!!} {{Form::hidden('_method', 'DELETE')}} {{Form::submit('Delete',['class'
                                            => 'btn btn-sm btn-danger delete-music'])}} {!!Form::close()!!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection @section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#categories-table').DataTable({
            responsive: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

    });
</script>
@endsection