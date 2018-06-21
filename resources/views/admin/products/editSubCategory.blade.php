@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}"> @endsection @section('content')

<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
    <a href="/admin/products/createSubCategory">{{$subCategory->category->category_name}}</a> &nbsp; <span data-feather="chevron-right"></span> &nbsp;{{$subCategory->sub_category_name}}
</div>

{!! Form::open(['action' => ['Admin\ProductsController@updateSubCategory', $subCategory->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
                        <option value="{{$subCategory->category->id}}">{{$subCategory->category->category_name}}</option>
                        @foreach ($categories as $category)
                            @if($category->category_name != $subCategory->category->category_name)
                                <option value="{{$category->id}}">{{ $category->category_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('subCategoryName', 'Sub Category', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('subCategoryName', $subCategory->sub_category_name, ['class' => 'form-control', 'placeholder' => 'Enter Sub Category Name'])}}
                </div>
            </div>
        </li>

        <li class="list-group-item text-center">{{Form::hidden('_method', 'PUT')}} {{Form::submit('Save', ['class' => 'btn btn-success'])}} {!! Form::close() !!}</li>
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
                                    <td>{{$subCategory->category->category_name}}</td>
                                    <td>{{$subCategory->sub_category_name}}</td>
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