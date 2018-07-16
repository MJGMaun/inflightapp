@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}"> @endsection @section('content')
{!! Form::open(['action' => ['Admin\SeriesController@update', $serie->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
    <a href="/admin/series/create">Create Series</a> &nbsp; <span data-feather="chevron-right"></span> &nbsp;{{$serie->title}}
</div>
<div class="card" style="width: 100%;">
    <div class="card-header">
        Series
    </div>
    <ul class="list-group list-group-flush">

        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('title', 'Title', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('title', $serie->title, ['class' => 'form-control', 'placeholder' => 'Enter Series Title'])}}
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('cast', 'Cast', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('cast', $serie->cast, ['class' => 'form-control', 'placeholder' => 'Enter Casts'])}}
                </div>
            </div>
        </li>
        <li  class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('main_genre', 'Main genre', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::select('main_genre', $serie->main_genre, ['1' => 'Action','2' => 'Adventure', '3' => 'Comedy', '4' => 'Drama', '5' => 'Horror', '6' => 'Romance', '7' => 'Sci-Fi & Fantasy', '8' => 'Kids', '0' => 'None'], null,
        ['class' => 'form-control', 'placeholder' => 'Select a main genre...'])}}
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="row">
                <div class="col">
                        {{Form::label('genres', 'Genres')}}
                        <div class="row">
                            @foreach($genres as $genre)
                            <div class="col-md-3 col-sm-3">
                                @if(in_array($genre->name, $serie_genres)) {{Form::checkbox('genres[]', $genre->name, ['checked' => 'checked'])}} &nbsp;{{$genre->name}}
                                @else {{Form::checkbox('genres[]', $genre->name)}} &nbsp;{{$genre->name}} @endif
                            </div>
                            @endforeach
                        </div>
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('release_date', 'Release Date', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::date('release_date', $serie->release_date, ['class' => 'form-control'])}}
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
        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('description', 'Description', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::textarea('description', $serie->description, ['class' => 'form-control', 'placeholder' => 'Enter Series Plot'])}}
                </div>
            </div>
        </li>

        <li class="list-group-item text-center">{{Form::hidden('_method', 'PUT')}} {{Form::submit('Save', ['class' => 'btn btn-success'])}} {!! Form::close() !!}</li>
    </ul>
</div>
<br>
<div class="card" style="width: 100%;">
    <div class="card-header">
        Manage Series
    </div>
    <br>
    <div style="width: 100%; padding-left: -10px; border: 1px;" class="">
        <div class="table-responsive">
            <table id="series-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
                <thead>
                    <tr>
                        <th>Cover Image</th>
                        <th>Title</th>
                        <th>Seasons</th>
                        <th>Episodes</th>
                        <th>Casts</th>
                        <th>Plot</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($series)) 
                            @foreach($series as $serie)
                                <tr>
                                    <td><img height="50px" width="60px" src="/storage/series_cover_images/{{$serie->coverimage->cover_image}}" /><span class="d-none">{{$serie->coverimage->cover_image}}</span></td>
                                    <td data-title="{{$serie->title}}">{{$serie->title}}</td>
                                    {{-- EDIT MODAL NAME OKIIIIII --}}
                                <td><button type="button" id="modal" class="btn btn-sm btn-primary" data-toggle="modal" data-pandi="{{$serie->id}}" data-target="#exampleModal">View Seasons</button></td>
                                    <td>View Episodes</td>
                                    <td>{{$serie->cast}}</td>
                                    <td>{{$serie->description}}</td>
                                    <td>{{$serie->created_at}}</td>
                                    <td>{{$serie->updated_at}}</td>
                                    <td>
                                        <div class="row">
                                        &nbsp;&nbsp;<a href="/admin/series/{{$serie->id}}/edit" class="btn btn-sm btn-primary" ><span data-feather="edit"></span></a>
                                        &nbsp; {!!Form::open(['action' => ['Admin\SeriesController@destroy', $serie->id], 'method'
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
{!!Html::script('js/datatable/dataTables.buttons.min.js')!!} {!!Html::script('js/datatable/buttons.flash.min.js')!!}
{!!Html::script('js/datatable/jszip.min.js')!!} {!!Html::script('js/datatable/pdfmake.min.js')!!} {!!Html::script('js/datatable/vfs_fonts.js')!!}
{!!Html::script('js/datatable/buttons.html5.min.js')!!} {!!Html::script('js/datatable/buttons.print.min.js')!!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#series-table').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "columnDefs": [
                {
                    "targets": 5,
                    render: function (data, type, row) {
                        return data.length > 20 ?
                            data.substr(0, 20) + '…' :
                            data;
                    }
                }
            ]
        });

    });
</script>
@endsection