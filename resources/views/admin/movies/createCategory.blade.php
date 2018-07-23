@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}"> @endsection @section('content')
{!! Form::open(['action' => 'Admin\MoviesController@storeCategory', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="card" style="width: 100%;">
    <div class="card-header">
        Category
    </div>
    <ul class="list-group list-group-flush">

        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('category', 'Category', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('category', '', ['class' => 'form-control', 'placeholder' => 'Enter Category Name'])}}
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('moviePriceEWallet', 'Movie E-Wallet Price', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                     {{Form::number('moviePriceEWallet', '', ['class' => 'form-control', 'placeholder' => 'E-Wallet Price'])}}
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="form-group row">
                    {{Form::label('moviePriceToken', 'Movie Token Price', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::number('moviePriceToken', '', ['class' => 'form-control', 'placeholder' => 'Token Price'])}}
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('description', 'Description', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Enter Category Description'])}}
                </div>
            </div>
        </li>

        <li class="list-group-item text-center">{{Form::submit('Save', ['class' => 'btn btn-success '])}} {!! Form::close() !!}</li>
    </ul>
</div>
<br>
<div class="card" style="width: 100%;">
    <div class="card-header">
        Manage Categories
    </div>
    <br>
    <div style="width: 100%; padding-left: -10px; border: 1px;" class="">
        <div class="table-responsive">
            <table id="categories-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>E-Wallet Price</th>
                        <th>Token Price</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($categories)) 
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->movie_category_name}}</td>
                                    <td>{{$category->movie_category_price_ewallet}}</td>
                                    <td>{{$category->movie_category_price_token}}</td>
                                    <td>{{$category->movie_category_description}}</td>
                                    <td>{{$category->created_at}}</td>
                                    <td>{{$category->updated_at}}</td>
                                    <td>
                                        <div class="row">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/movies/{{$category->id}}/editCategory" class="btn btn-sm btn-primary" ><span data-feather="edit"></span></a>
                                        &nbsp; {!!Form::open(['action' => ['Admin\MoviesController@destroyCategory', $category->id], 'method'
                                            => 'POST', 'class' => 'float-right'])!!} {{Form::hidden('_method', 'DELETE')}} {{Form::button('<span data-feather="trash"></span>',['type' => 'submit','class' => 'btn btn-sm btn-danger delete-music'])}} {!!Form::close()!!}
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