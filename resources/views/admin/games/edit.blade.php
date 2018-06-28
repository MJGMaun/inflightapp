@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}"> @endsection @section('content')
{!! Form::open(['action' => ['Admin\GamesController@update', $game->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
    <a href="/admin/products/createCategory">Create Games</a> &nbsp; <span data-feather="chevron-right"></span> &nbsp;{{$game->name}}
</div>
<div class="card" style="width: 100%;">
    <div class="card-header">
        Category
    </div>
    <ul class="list-group list-group-flush">

        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('name', 'Game Name', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('name', $game->name, ['class' => 'form-control', 'placeholder' => 'Enter Game Name'])}}
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('game_apk', 'Game APK', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::file('game_apk')}}
            </div>
        </div>
        </li>
        <li class="list-group-item center text-center">
        <div class="form-group row">
            {{Form::label('cover_image', 'Cover Image', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-7">
                {{Form::file('cover_image')}}
            </div>
        </div>
        </li>

        <li class="list-group-item text-center">{{Form::hidden('_method', 'PUT')}} {{Form::submit('Save', ['class' => 'btn btn-success'])}} {!! Form::close() !!}</li>
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
                        <th>Cover Image</th>
                        <th>Name</th>
                        <th>APK</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($games)) 
                            @foreach($games as $game)
                                <tr>
                                    <td><img height="50px" width="60px" src="/storage/games_cover_images/{{$game->cover_image}}" /><span class="d-none">{{$game->cover_image}}</span></td>
                                    <td>{{$game->name}}</td>
                                    <td>{{$game->APK}}</td>
                                    <td>{{$game->created_at}}</td>
                                    <td>{{$game->updated_at}}</td>
                                    <td>
                                        <div class="row">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/products/{{$game->id}}/editCategory" class="btn btn-sm btn-primary" ><span data-feather="edit"></span></a>
                                        &nbsp; {!!Form::open(['action' => ['Admin\GamesController@destroy', $game->id], 'method'
                                            => 'POST', 'class' => 'float-right'])!!} {{Form::hidden('_method', 'DELETE')}} {{Form::button('<span data-feather="trash"></span>',['type' => 'submit','class' => 'btn btn-sm btn-danger delete-music'])}} {!!Form::close()!!}
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