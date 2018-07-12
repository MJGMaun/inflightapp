@extends('admin.layouts.app') @section('css') @endsection @section('content')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}">
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Scratch Cards</h1>
</div>

<a class="btn btn-sm btn-primary" href="/admin/scratchcards/create">
    <span data-feather="plus"></span>
    Scratch Cards
</a>
<br>
<br>


<div style="width: 100%; padding-left: -10px; border: 1px;">
    <div class="table-responsive">
        <table id="scratchcards-table" class="table table-striped table-hover dt-responsive display cell-border" cellspacing="0">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Amount</th>
                    <th>PIN</th>
                    <th>Card Expiration</th>
                    <th>Card Validity</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($scratchcards))
                @foreach($scratchcards as $scratchcard)
                <tr>
                    <td>{{str_repeat("*", strlen($scratchcard->code)-3) . substr($scratchcard->code, -3)}}</td>
                    <td>{{$scratchcard->amount}}</td>
                    <td>{{$scratchcard->pin}}</td>
                    <td>{{$scratchcard->card_expiration}}</td>
                    <td>{{$scratchcard->card_validity}}</td>
                    <td>{{$scratchcard->status}}</td>
                    <td>{{$scratchcard->created_at}}</td>
                    <td>{{$scratchcard->updated_at}}</td>
                    <td><div class="row">
                        {!!Form::open(['action' => ['Admin\ScratchCardsController@destroy', $scratchcard->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{Form::button('<span data-feather="trash"></span>',['type' => 'submit','class' => 'btn btn-sm btn-danger'])}}
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
        $('#scratchcards-table').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
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