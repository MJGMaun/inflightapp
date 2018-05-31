@extends('admin.layouts.app') @section('css') @endsection @section('content')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
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
        <table id="movies-table" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
            <thead>
                <tr>
                    <th>Cover Image</th>
                    <th>Title</th>
                    {{--
                    <th>Movie Description</th> --}}
                    <th>Language</th>
                    <th>Running Time</th>
                    <th>Release Date</th>
                    <th>Movie Location</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movies as $movie)
                <tr>
                    <td>
                        <img height="50px" width="50px" src="/storage/cover_images/{{$movie->cover_image}}" /><span class="d-none">{{$movie->cover_image}}</span></td>
                    <td>{{$movie->title}}</td>
                    {{--
                    <td>{{$movie->movie_description}}</td> --}}
                    <td>{{$movie->language}}</td>
                    <td>{{$movie->running_time}}</td>
                    <td>{{$movie->release_date}}</td>
                    <td>{{$movie->movie_video}}</td>
                    <td>{{$movie->created_at}}</td>
                    <td>{{$movie->updated_at}}</td>
                    <th></th>
                </tr>
                @endforeach
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
                }
                ,
                {
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<button class='btn btn-primary edit-movie'>Edit</button>&nbsp;<button class='btn btn-danger delete-movie'>Delete</button>"
                }
            ]
        });
        var table = $('#movies-table').DataTable();
        $('#movies-table tbody').on('click', '.btn.btn-primary.edit-movie', function () {
            var data = table.row($(this).parents('tr')).data();
            alert(data[2] + "'s salary is: " + data[3]);
        });
        $('#movies-table tbody').on('click', '.btn.btn-danger.delete-movie', function () {
            var data = table.row($(this).parents('tr')).data();
            alert(data[2] + "'s salary is: " + data[3]);
        });
    });
</script>
@endsection