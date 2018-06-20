@extends('admin.layouts.app') @section('css') @endsection @section('content')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<div class="row flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
   <a href="/admin/musics/">Artists</a> &nbsp; <span data-feather="chevron-right"></span><a href="/admin/musics/{{$artist->id}}/editArtist">{{$artist->artist_name}}</a> &nbsp; <span data-feather="chevron-right"></span>
    &nbsp;
   {{$album->album_name}}
</div>

<a class="btn btn-sm btn-primary" href="/admin/musics/create">
    <span data-feather="plus"></span>
    Add Song
</a>
<br>
<br>


<div style="width: 100%; padding-left: -10px; border: 1px;" class="">
    <div class="table-responsive">
            <table id="musics-table" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
            <thead>
                <tr>
                    <th>Cover Image</th>
                    <th>Song Name</th>
                    <th>Genre</th>
                    <th>Music Location</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    {{-- @if(count($musics)) --}}
                    @foreach($album->songs as $song)
                    <tr>
                        <td>
                            <img height="50px" width="60px" src="/storage/cover_images/{{$song->coverimage->cover_image}}" /><span class="d-none">{{$song->cover_image}}</span></td>
                        <td>{{$song->title}}</td>
                        <td>{{$song->genre}}</td>
                        <td>{{$song->music_song}}</td>
                        {{-- <td>@foreach($music->albums as $album)
                        <li><a href="/admin/musics/{{$album->id}}">{{ $album->album_name }} </a></li>
                            @endforeach</td> --}}
                        <td>{{$song->created_at}}</td>
                        <td>{{$song->updated_at}}</td>
                        <td><div class="row">
                            <a href="/admin/musics/{{$song->id}}/edit" class="btn btn-sm btn-primary edit-music"><span data-feather="edit"></span></a>&nbsp;
                            {!!Form::open(['action' => ['Admin\MusicsController@destroy', $song->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete',['class' => 'btn btn-sm btn-danger delete-music'])}}
                            {!!Form::close()!!}</div></td>
                    </tr>
                    @endforeach
                    {{-- @else
                    <p>No Songs</p>
                    @endif --}}

            </tbody>
        </table>
    </div>
</div>

@endsection @section('script') {!!Html::script('js/datatable/dataTables.buttons.min.js')!!} {!!Html::script('js/datatable/buttons.flash.min.js')!!}
{!!Html::script('js/datatable/jszip.min.js')!!} {!!Html::script('js/datatable/pdfmake.min.js')!!} {!!Html::script('js/datatable/vfs_fonts.js')!!}
{!!Html::script('js/datatable/buttons.html5.min.js')!!} {!!Html::script('js/datatable/buttons.print.min.js')!!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#musics-table').DataTable({
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
                    "targets": 7,
                    render: function (data, type, row) {
                        return data.length > 10 ?
                            data.substr(0, 10) + '…' :
                            data;
                    }
                }
            ]
        });
        // var table = $('#musics-table').DataTable();
        // $('#musics-table tbody').on('click', '.btn.btn-primary.edit-music', function () {
        //     var data = table.row($(this).parents('tr')).data();
        // });
        // $('#musics-table tbody').on('click', '.btn.btn-danger.delete-music', function () {
        //     var data = table.row($(this).parents('tr')).data();
        // });


    });
</script>
@endsection