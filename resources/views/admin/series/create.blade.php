@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}"> @endsection @section('content')
{!! Form::open(['action' => 'Admin\SeriesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="card" style="width: 100%;">
    <div class="card-header">
        Series
    </div>
    <ul class="list-group list-group-flush">

        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('title', 'Title', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Enter Series Title'])}}
                </div>
            </div>
        </li>
        <li  class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('cast', 'Cast', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('cast', '', ['class' => 'form-control', 'placeholder' => 'Enter Casts'])}}
                </div>
            </div>
        </li>
        <li  class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('main_genre', 'Main genre', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::select('main_genre', ['1' => 'Action','2' => 'Adventure', '3' => 'Comedy', '4' => 'Drama', '5' => 'Horror', '6' => 'Romance', '7' => 'Sci-Fi & Fantasy', '8' => 'Kids', '0' => 'None'], null,
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
                                    {{Form::checkbox('genres[]', $genre->name)}}&nbsp;{{$genre->name}} 
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
                    {{Form::date('release_date', null, ['class' => 'form-control'])}}
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
                    {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Enter Series Plot'])}}
                </div>
            </div>
        </li>

        <li class="list-group-item text-center">{{Form::submit('Save', ['class' => 'btn btn-success '])}} {!! Form::close() !!}</li>
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
                                <td><button type="button" id="modal" class="btn btn-sm btn-primary" data-toggle="modal" data-id="{{$serie->id}}" data-target="#exampleModal">View Seasons</button></td>
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



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark" style="color: #fff;">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" style="color: #fff;" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            Number of Seasons: <span class="number"></span><br>
            <hr>
            <div class="details"></div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
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

        //MODAL
    $('#series-table tbody').on('click', '#modal', function () {
        $('.number, .season-number, .details, .modal-title').empty();
            var table = $('#series-table').DataTable();
            var series_title = $(this).closest('tr').find("td:eq(1)").text();
            var serie_id=$(this).data("id");
            var header=" ";
            var details=" ";

            $.ajax({
                type:'get',
                url:'{!!URL::to('json_seasons_modal')!!}',
                data:{'id':serie_id},
                dataType: 'json',
                success:function(data){
                    //var dataLength = Object.keys(data).length;
                    var dataLength = data.length; 
                    header+=series_title;
                    for(var i=0;i<dataLength;i++){
                        details+='<img height="70px" width="80px" src="/storage/series_cover_images/'+data[i].season_cover_image+'"></img><br>';
                        details+='<p>Season: '+data[i].season_number+'<a href="'+data[i].season_id+'/editSeason" class="btn btn-sm btn-primary pull-right">Edit Season</a></p>';

                        for(var x=0;x<data[i].episodes.length;x++){
                        details+='<hr><div class="row"><div class="col-6">Episode '+data[i].episodes_number[x]+': <a href="admin/series/'+data[i].episodes_id[x]+'/editEpisode">'+' '+data[i].episodes[x]+'</a></div><div class="col-6"><button class="btn btn-sm btn-danger delete-episode" data-id="'+data[i].episodes_id[x]+'" data-token="{{ csrf_token() }}">Delete</button><a href="/admin/series/'+data[i].episodes_id[x]+'/editEpisode" class="btn btn-sm btn-primary pull-right" ><span data-feather="edit">Edit</span></a></div></div>';
                        }
                        details+='<hr>';
                   }
                   
                    // FOR NEW ALBUM OPTION APPEND ALBUM NAME
                   $(document).find('.number').html(dataLength);
                   $(document).find('.season-number').html();
                   $(document).find('.modal-title').append(header);
                   $(document).find('.details').append(details);
                },
                error:function(){
                    console.log('error');
                }
            });
        });



        //DELETE EPISODE
        $(document).on('click','.delete-episode',function(){
            var episode_id = $(this).data("id");
            
            $.confirm({
                title: 'DELETE EPISODE',
                content: 'Are you sure you want to delete this episode?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                        confirm: {
                            text: 'Delete',
                            btnClass: 'btn-red',
                            action: function(){
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    type: 'POST',
                                    url: 'destroyEpisode/' + episode_id,
                                    data: {
                                        '_token':$('.delete-episode').data('token'),
                                    },
                                    contentType: false,
                                    processData: false,
                                    success: function(data) {
                                    // $('.post' + $('.id').text()).remove();
                                    $.alert('Successfully deleted '+data.title+'!');
                                    
                                    }
                                });
                            }
                        },
                        cancel: function () {
                            $.alert('Canceled!');
                        }
                }
            });
            
        });
            
</script>
@endsection