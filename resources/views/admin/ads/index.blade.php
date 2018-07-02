@extends('admin.layouts.app') @section('css') @endsection @section('content')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Advertisements</h1>
</div>

<a class="btn btn-sm btn-primary" href="/admin/ads/create">
    <span data-feather="plus"></span>
    Add Advertisement
</a>
<br>
<br>


<div style="width: 100%; padding-left: -10px; border: 1px;">
    <div class="table-responsive">
        <table id="ads-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
            <thead>
                <tr>
                    <th>Ad Name</th>
                    <th>Roll</th>
                    <th>Time</th>
                    <th>Plays Needed</th>
                    <th>Plays Remaining</th>
                    <th>Status</th>
                    <th>Filename</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($ads))
                @foreach($ads as $ad)
                <tr>
                    <td>{{$ad->name}}</td>
                    <td>{{$ad->roll}}</td>
                    <td>{{$ad->time}}</td>
                    <td>{{$ad->number_of_plays_needed}}</td>
                    <td>{{$ad->number_of_plays_remaining}}</td>
                    <td>@if($ad->status == 'On going')
                        <span class="btn btn-sm btn-info">{{$ad->status}}</span>
                    @elseif($ad->status = 'Done')
                        <span class="btn btn-sm btn-success">{{$ad->status}}</span>
                    @else
                        <span class="btn btn-sm btn-error">No Status</span>
                    @endif</td>
                    <td>{{$ad->ad_video}}</td>
                    <td>{{$ad->created_at}}</td>
                    <td>{{$ad->updated_at}}</td>
                    <td><div class="row">
                        &nbsp;&nbsp;<a href="/admin/ads/{{$ad->id}}/edit" class="btn btn-sm btn-primary"><span data-feather="edit"></span></a>&nbsp;
                        {!!Form::open(['action' => ['Admin\AdsController@destroy', $ad->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::button('<span data-feather="trash"></span>',['type' => 'submit','class' => 'btn btn-sm btn-danger'])}}
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
        $('#ads-table').DataTable({
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