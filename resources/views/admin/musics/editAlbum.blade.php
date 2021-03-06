@extends('admin.layouts.app')
@section('css') 
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}">
@endsection
@section('content')

<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
   <a href="/admin/musics/">Artists</a> &nbsp; <span data-feather="chevron-right"></span><a href="/admin/musics/{{$artist->id}}/editArtist">{{$artist->artist_name}}</a> &nbsp; <span data-feather="chevron-right"></span>
    &nbsp;
   {{$album->album_name}}
</div>

{!! Form::open(['action' => ['Admin\MusicsController@updateAlbum', $album->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'])
!!}
<div class="card">
  <div class="card-header">
    Edit Album
  </div>
  <div class="card-body">
<div class="row">
    <div class="col-md-6 col-sm-6 add-artists">
        {{Form::label('album', 'Album Name')}}
        {{Form::text('album', $album->album_name, ['class'
        => 'form-control', 'placeholder' => 'Artist Name'])}}
    </div>
    <div class="col-md-6 col-sm-6">
        {{Form::label('cover_image', 'Cover Image')}}
        <br> {{Form::file('cover_image')}}
    </div>
</div><br> 
<div class="row">
    <div class="col-md-4 col-sm-4 add-artists">
        {{Form::label('categories[]', 'Category')}}
        {{Form::select('categories[]', ['1' => 'Top Albums of The Month','2' => 'New Album Released', '3' => 'Popular Album', '0' => 'None'], $album->category,
        ['class' => 'form-control', 'placeholder' => 'Select a category...'])}}
    </div>
    <div class="col-md-4 col-sm-4">
        {{Form::label('release_date[]', 'Release Date')}}
        <br> {{Form::date('release_date[]', $album->release_date, ['class' => 'form-control'])}}
    </div>
    <div class="col-md-4 col-sm-4">
        {{Form::label('album_description[]', 'Album Description')}}
        <br> {{Form::textarea('album_description[]', $album->description, ['class' => 'form-control',
    'placeholder' => 'Enter album description here', 'rows' => '1'])}}
    </div>
</div><br> 
<div class="row">
    <div class="col-md-6 col-sm-6 add-artists">
            {{Form::hidden('_method', 'PUT')}} {{Form::submit('Save', ['class' => 'btn btn-success'])}} {!! Form::close() !!}
    </div>
</div>
</div><br>
</div>
<br>
<div class="card">
  <div class="card-header text-center">
    <h5>{{$album->album_name}} Songs</h5>
    <a class="btn btn-sm btn-primary pull-left" href="/admin/musics/{{$album->id}}/createWId">
    <span data-feather="plus"></span>
    Add Song
</a>
  </div>
  <div class="card-body">
<div style="width: 100%; padding-left: -10px; border: 1px;" class="">
    <div class="table-responsive">
        <table id="musics-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
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
                            <img height="50px" width="60px" src="/storage/cover_images/{{{$song->coverimage->cover_image}}}" /><span class="d-none">{{$song->cover_image}}</span></td>
                        <td>{{$song->title}}</td>
                        <td>{{$song->genre}}</td>
                        <td>{{$song->music_song}}</td>
                        {{-- <td>@foreach($music->albums as $album)
                        <li><a href="/admin/musics/{{$album->id}}">{{ $album->album_name }} </a></li>
                            @endforeach</td> --}}
                        <td>{{$song->created_at}}</td>
                        <td>{{$song->updated_at}}</td>
                        <td><div class="row">
                            &nbsp;&nbsp;&nbsp;<a href="/admin/musics/{{$song->id}}/edit" class="btn btn-sm btn-primary edit-music"><span data-feather="edit"></span></a>&nbsp;
                            {!!Form::open(['action' => ['Admin\MusicsController@destroy', $song->id], 'method' =>
                            'POST', 'class' => 'float-right'])!!} {{Form::hidden('_method', 'DELETE')}} {{Form::button('<span data-feather="trash"></span>',['type' => 'submit','class' => 'btn btn-sm btn-danger delete-music'])}} {!!Form::close()!!}</div></td>
                    </tr>
                    @endforeach
                    {{-- @else
                    <p>No Songs</p>
                    @endif --}}

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
        $('#musics-table').DataTable({
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