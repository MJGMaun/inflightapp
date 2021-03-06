@extends('admin.layouts.app')
@section('css') 
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}">
@endsection
@section('content')

<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
    <a href="/admin/musics/">Artists</a> &nbsp; <span data-feather="chevron-right"></span> &nbsp;{{$artist->artist_name}}
</div>

{!! Form::open(['action' => ['Admin\MusicsController@updateArtist', $artist->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'])
!!}
<div class="card">
  <div class="card-header">
    Edit Artist
  </div>
  <div class="card-body">
<div class="row">
    <div class="col-md-6 col-sm-6 add-artists">
        {{Form::label('artist', 'Artist Name')}} {{Form::text('artist', $artist->artist_name, ['class'
        => 'form-control', 'placeholder' => 'Artist Name'])}} 
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="form-group" style="margin: 7px;"><br>
            {{Form::hidden('_method', 'PUT')}} {{Form::submit('Save', ['class' => 'btn btn-success'])}} {!! Form::close() !!}
        </div>
    </div>
</div>
</div>
</div>
<br>
<div class="card">
  <div class="card-header text-center">
    <h5>{{$artist->artist_name}}</h5> <a class="btn btn-sm btn-primary  pull-left" href="/admin/musics/{{$artist->id}}/createAlbumWId">
    <span data-feather="plus"></span>
    Add Album
</a>
  </div>
  <div class="card-body">
<div style="width: 100%; padding-left: -10px; border: 1px;" class="">
    <div class="table-responsive">
        <table id="albums-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
            <thead>
                <tr>
                    <th>Cover Image</th>
                    <th>Albums</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($artist->albums)) @foreach($artist->albums as $album)
                <tr>
                    <td>
                        <img height="50px" width="60px" src="/storage/cover_images/{{$album->coverimage->cover_image}}" />
                        <span class="d-none">{{$album->cover_image}}</span>
                    </td>
                    <td>{{$album->album_name}}</td>
                    {{--
                    <td>@foreach($artist->albums as $album)
                        <li>
                            <a href="/admin/musics/{{$album->id}}">{{ $album->album_name }} </a>
                        </li>
                        @endforeach</td> --}}
                    <td>{{$album->created_at}}</td>
                    <td>{{$album->updated_at}}</td>
                    <td>
                        <div class="row">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/admin/musics/{{$album->id}}/createWId" class="btn btn-sm btn-success" title="Add Song ({{$album->album_name}})"><span data-feather="plus"></span></a>&nbsp;
                            <a href="/admin/musics/{{$album->id}}/editAlbum" class="btn btn-sm btn-primary edit-music" title="Edit Album ({{$album->album_name}})">
                                <span data-feather="edit"></span>
                            </a>&nbsp; {!!Form::open(['action' => ['Admin\MusicsController@destroyAlbum', $album->id], 'method' =>
                            'POST', 'class' => 'float-right'])!!} {{Form::hidden('_method', 'DELETE')}} {{Form::button('<span data-feather="trash"></span>',['type' => 'submit','class' => 'btn btn-sm btn-danger delete-music'])}}{!!Form::close()!!}
                        </div>
                    </td>
                </tr>
                @endforeach @endif
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
<br>



@endsection @section('script') {!!Html::script('js/datatable/dataTables.buttons.min.js')!!} {!!Html::script('js/datatable/buttons.flash.min.js')!!}
{!!Html::script('js/datatable/jszip.min.js')!!} {!!Html::script('js/datatable/pdfmake.min.js')!!} {!!Html::script('js/datatable/vfs_fonts.js')!!}
{!!Html::script('js/datatable/buttons.html5.min.js')!!} {!!Html::script('js/datatable/buttons.print.min.js')!!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#albums-table').DataTable({
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