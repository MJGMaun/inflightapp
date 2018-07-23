@extends('admin.layouts.app')
@section('css') 
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}">
@endsection
@section('content')
<div class="card">
  <div class="card-header text-center">
    <h4>Artists</h4>
    <a class="btn btn-sm btn-primary pull-left" href="/admin/musics/createArtist">
        <span data-feather="plus"></span>
        Add Artist
    </a>
  </div>
  <div class="card-body">
<div style="width: 100%; padding-left: -10px; border: 1px;" class="">
    <div class="table-responsive">
            <table id="artists-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
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
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a title="Add New Album" href="/admin/musics/{{$artist->id}}/createAlbumWId" class="btn btn-sm btn-success"><span data-feather="plus"></span></a>&nbsp;
                            <a title="Edit Artist" href="/admin/musics/{{$artist->id}}/editArtist" class="btn btn-sm btn-primary"><span data-feather="edit"></span></a>&nbsp;
                            {!!Form::open(['action' => ['Admin\MusicsController@destroyArtist', $artist->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::button('<span data-feather="trash"></span>',['title' => 'Delete Artist','type' => 'submit','class' => 'btn btn-sm btn-danger delete-music'])}}
                            {!!Form::close()!!}</div></td>
                    </tr>
                    @endforeach
                    @endif
            </tbody>
        </table>
    </div>
</div>
    </div>
</div>
<br><br><br>

<div class="card">
  <div class="card-header text-center">
    <h4>Albums</h4>
    <a class="btn btn-sm btn-primary pull-left" href="/admin/musics/createArtist">
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
                    <th>Songs</th>
                    <th>Artist Name</th>
                    <th>Category</th>
                    <th>Release Date</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th style="padding-right: 50px;">Action</th>
                </tr>
            </thead>
            <tbody>
                    @if(count($albums))
                    @foreach($albums as $album)
                    <tr>
                        {{-- <td><img height="50px" width="60px" src="/storage/cover_images/{{$music->cover_image}}" /><span class="d-none">{{$music->cover_image}}</span></td> --}}
                        <td><img height="50px" width="60px" src="/storage/cover_images/{{$album->coverimage->cover_image}}" /><span class="d-none">{{$album->coverimage->cover_image}}</span></td>
                        <td>@foreach($album->songs as $song)
                        <li>{{ $song->title }}</li>
                            @endforeach</td>
                        <td>{{$album->artists->artist_name}}</td>
                         <td>@if($album->category == 1)
                                Top Albums of The Month
                            @elseif($album->category == 2)
                                New Albums Released
                            @elseif($album->category == 3)
                                Popular Albums
                            @else
                                None
                            @endif
                        <td>{{$album->release_date}}</td>
                        <td>{{$album->description}}</td> 
                        <td>{{$artist->created_at}}</td>
                        <td>{{$artist->updated_at}}</td>
                        <td><div class="row">
                            &nbsp;&nbsp;<a title="Add New Songs" href="/admin/musics/{{$album->id}}/createWId" class="btn btn-sm btn-success"><span data-feather="plus"></span></a>&nbsp;
                            <a title="Edit Album" href="/admin/musics/{{$artist->id}}/editAlbum" class="btn btn-sm btn-primary"><span data-feather="edit"></span></a>&nbsp;
                            {!!Form::open(['action' => ['Admin\MusicsController@destroyAlbum', $album->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::button('<span data-feather="trash"></span>',['title' => 'Delete Artist','type' => 'submit','class' => 'btn btn-sm btn-danger delete-music'])}}
                            {!!Form::close()!!}</div></td>
                    </tr>
                    @endforeach
                    @endif
            </tbody>
        </table>
    </div>
</div>
    </div>
</div>
<br><br><br>

<div class="card">
  <div class="card-header text-center">
    <h4>Songs</h4>
    <a class="btn btn-sm btn-primary pull-left" href="/admin/musics/create">
        <span data-feather="plus"></span>
        Add Song
    </a>
  </div>
  <div class="card-body">
<div style="width: 100%; padding-left: -10px; border: 1px;" class="">
    <div class="table-responsive">
            <table id="songs-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
            <thead>
                <tr>
                    <th>Cover Image</th>
                    <th>Title</th>
                    <th>Artist Name</th>
                    <th>Album Name</th>
                    <th>Genre</th>
                    <th>Music Location</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    @if(count($songs))
                    @foreach($songs as $song)
                    <tr>
                        {{-- <td><img height="50px" width="60px" src="/storage/cover_images/{{$music->cover_image}}" /><span class="d-none">{{$music->cover_image}}</span></td> --}}
                        <td><img height="50px" width="60px" src="/storage/cover_images/{{$song->coverimage->cover_image}}" /><span class="d-none">{{$song->coverimage->cover_image}}</span></td>
                        <td>{{$song->title}}</td>
                        <td>{{$song->albums->artists->artist_name}}</td>
                        <td>{{$song->albums->album_name}}</td>
                        <td>{{$song->genre}}</td>
                        <td>{{$song->music_song}}</td>
                        <td>{{$song->created_at}}</td>
                        <td>{{$song->updated_at}}</td>
                        <td><div class="row">
                            &nbsp;&nbsp;
                            <a title="Edit Album" href="/admin/musics/{{$song->id}}/edit" class="btn btn-sm btn-primary"><span data-feather="edit"></span></a>&nbsp;
                            {!!Form::open(['action' => ['Admin\MusicsController@destroy', $song->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::button('<span data-feather="trash"></span>',['title' => 'Delete Artist','type' => 'submit','class' => 'btn btn-sm btn-danger delete-music'])}}
                            {!!Form::close()!!}</div></td>
                    </tr>
                    @endforeach
                    @endif
            </tbody>
        </table>
    </div>
</div>
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
        $('#albums-table').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#songs-table').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endsection