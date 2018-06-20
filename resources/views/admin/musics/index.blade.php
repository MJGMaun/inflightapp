@extends('admin.layouts.app')
@section('css') 
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}">
@endsection
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Artists</h1>
</div>
<a class="btn btn-sm btn-primary" href="/admin/musics/createArtist">
    <span data-feather="plus"></span>
    Add Artist
</a>
<a class="btn btn-sm btn-primary" href="/admin/musics/createArtist">
    <span data-feather="plus"></span>
    Add Album
</a>
<a class="btn btn-sm btn-primary" href="/admin/musics/create">
    <span data-feather="plus"></span>
    Add Song
</a>
<br>
<br>


<div style="width: 100%; padding-left: -10px; border: 1px;" class="">
    <div class="table-responsive">
            <table id="artists-table" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
            <thead>
                <tr>
                    <th>Artist Name</th>
                    <th>Albums</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    @if(count($artists))
                    @foreach($artists as $artist)
                    <tr>
                        {{-- <td><img height="50px" width="60px" src="/storage/cover_images/{{$music->cover_image}}" /><span class="d-none">{{$music->cover_image}}</span></td> --}}
                        <td>{{$artist->artist_name}}</td>
                        <td>@foreach($artist->albums as $album)
                        <li><a href="/admin/musics/{{$album->id}}">{{ $album->album_name }} </a></li>
                            @endforeach</td>
                        <td>{{$artist->created_at}}</td>
                        <td>{{$artist->updated_at}}</td>
                        <td><div class="row">
                            <a href="/admin/musics/{{$artist->id}}/editArtist" class="btn btn-sm btn-primary edit-music"><span data-feather="edit"></span></a>&nbsp;
                            {!!Form::open(['action' => ['Admin\MusicsController@destroyArtist', $artist->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete',['class' => 'btn btn-sm btn-danger delete-music'])}}
                            {!!Form::close()!!}</div></td>
                    </tr>
                    @endforeach
                    @endif
            </tbody>
        </table>
    </div>
</div>

@endsection @section('script')
{!!Html::script('js/datatable/dataTables.buttons.min.js')!!}
{!!Html::script('js/datatable/buttons.flash.min.js')!!}
{!!Html::script('js/datatable/jszip.min.js')!!}
{!!Html::script('js/datatable/pdfmake.min.js')!!}
{!!Html::script('js/datatable/vfs_fonts.js')!!}
{!!Html::script('js/datatable/buttons.html5.min.js')!!}
{!!Html::script('js/datatable/buttons.print.min.js')!!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#artists-table').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
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