@extends('admin.layouts.app') @section('css') @endsection @section('content')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Movies</h1>
</div>

<a class="btn btn-sm btn-primary" href="/admin/movies/create">
    <span data-feather="plus"></span>
    Add Movie
</a>
<br>
<br>


<div style="width: 100%; padding-left: -10px; border: 1px;">
    <div class="table-responsive">
        <table id="movies-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
            <thead>
                <tr>
                    <th>Cover Image</th>
                    <th>Title</th>
                    {{--
                    <th>Movie Description</th> --}}
                    <th>Genres</th>
                    <th>Casts</th>
                    <th>Director</th>
                    <th>Running Time</th>
                    <th>Release Date</th>
                    <th>Category</th>
                    <th>Content Rating</th>
                    <th>E-Wallet Price</th>
                    <th>Token Price</th>
                    <th>Movie Location</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($movies))
                @foreach($movies as $movie)
                <tr>
                    <td>
                        <img height="50px" width="60px" src="/storage/cover_images/{{$movie->cover_image}}" /><span class="d-none">{{$movie->cover_image}}</span></td>
                    <td>{{$movie->title}}</td>
                    {{--
                    <td>{{$movie->movie_description}}</td> --}}
                    <td>@foreach($movie->genres as $genre)
                        {{ $genre->name }}
                    @endforeach</td>
                    <td>{{$movie->cast}}</td>
                    <td>{{$movie->director}}</td>
                    <td>{{$movie->running_time}}</td>
                    <td>{{$movie->release_date}}</td>
                    <td>{{$movie->category->movie_category_name}}</td>
                    <td>{{$movie->content_rating}}</td>
                    <td>{{$movie->ewallet_price}}</td>
                    <td>{{$movie->token_price}}</td>
                    <td>{{$movie->movie_video}}</td>
                    <td>{{$movie->created_at}}</td>
                    <td>{{$movie->updated_at}}</td>
                    <td><div class="row">
                        &nbsp;&nbsp;<a href="/admin/movies/{{$movie->id}}/edit" class="btn btn-sm btn-primary edit-movie"><span data-feather="edit"></span></a>&nbsp;
                        {!!Form::open(['action' => ['Admin\MoviesController@destroy', $movie->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::button('<span data-feather="trash"></span>',['type' => 'submit','class' => 'btn btn-sm btn-danger delete-music'])}}
                        {!!Form::close()!!}</div></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection @section('script') {!!Html::script('js/datatable/dataTables.buttons.min.js')!!} {!!Html::script('js/datatable/buttons.flash.min.js')!!}
{!!Html::script('js/datatable/jszip.min.js')!!} {!!Html::script('js/datatable/pdfmake.min.js')!!} {!!Html::script('js/datatable/vfs_fonts.js')!!}
{!!Html::script('js/datatable/buttons.html5.min.js')!!} {!!Html::script('js/datatable/buttons.print.min.js')!!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#movies-table').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "columnDefs": [
                {
                    "targets": 5,
                    render: function (data, type, row) {
                        return data.length > 10 ?
                            data.substr(0, 10) + '…' :
                            data;
                    }
                },
                {
                    "targets": 10,
                    render: function (data, type, row) {
                        return data.length > 10 ?
                            data.substr(0, 10) + '…' :
                            data;
                    }
                }
            ]
        });
        // var table = $('#movies-table').DataTable();
        // $('#movies-table tbody').on('click', '.btn.btn-primary.edit-movie', function () {
        //     var data = table.row($(this).parents('tr')).data();
        // });
        // $('#movies-table tbody').on('click', '.btn.btn-danger.delete-movie', function () {
        //     var data = table.row($(this).parents('tr')).data();
        // });


    });
</script>
@endsection