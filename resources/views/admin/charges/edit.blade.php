@extends('admin.layouts.app') @section('css')
<link rel="stylesheet" href="{{ asset('css/jquery.dataTables.css') }}"> @endsection @section('content')

<div class="d-flex align-items-center pb-2 mb-3 border-bottom">
    <a href="/admin/charges/create">Create Charge</a> &nbsp; <span data-feather="chevron-right"></span> &nbsp;{{$charge->name}}
</div>
{!! Form::open(['action' => ['Admin\ChargesController@update', $charge->id ], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="card" style="width: 100%;">
    <div class="card-header">
        Charges
    </div>
    <ul class="list-group list-group-flush">

        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('name', 'Charge Name', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('name', $charge->name, ['class' => 'form-control', 'placeholder' => 'Enter Charge Name'])}}
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="form-group row">
                {{Form::label('symbol', 'Charge Symbol', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::text('symbol', '', ['class' => 'form-control', 'placeholder' => 'Enter Charge Symbol', 'maxlength' => '1'])}}
                </div>
            </div>
        </li>
        <li class="list-group-item center text-center">
            <div class="form-group row">
                    {{Form::label('value', 'Charge Value', ['class' => 'col-sm-3 col-form-label'])}}
                <div class="col-sm-7">
                    {{Form::number('value', $value, ['class' => 'form-control', 'placeholder' => 'Charge Value', 'max' => '100', 'min' => '1'])}}
                </div>
            </div>
        </li>

        <li class="list-group-item text-center">{{Form::hidden('_method', 'PUT')}} {{Form::submit('Save', ['class' => 'btn btn-success'])}} {!! Form::close() !!}</li>
    </ul>
</div>
<br>

<br>
<div class="card" style="width: 100%;">
    <div class="card-header">
        Manage Charges
    </div>
    <br>
    <div style="width: 100%; padding-left: -10px; border: 1px;" class="">
        <div class="table-responsive">
            <table id="categories-table" class="table table-striped table-hover dt-responsive display nowrap" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($charges)) 
                        @php
                            $x = 1;
                        @endphp
                            @foreach($charges as $charge)

                                <tr>
                                    <td>{{$x}}</td>
                                    <td>{{$charge->name}}</td>
                                    <td>{{$charge->value}}</td>
                                    <td>{{$charge->created_at}}</td>
                                    <td>{{$charge->updated_at}}</td>
                                    <td>
                                        <div class="row">
                                        <a href="/admin/charges/{{$charge->id}}/edit" class="btn btn-sm btn-primary" ><span data-feather="edit"></span></a>
                                        &nbsp; {!!Form::open(['action' => ['Admin\ChargesController@destroy', $charge->id], 'method'
                                            => 'POST', 'class' => 'float-right'])!!} {{Form::hidden('_method', 'DELETE')}} {{Form::submit('Delete',['class'
                                            => 'btn btn-sm btn-danger delete-music'])}} {!!Form::close()!!}
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $x += 1;
                                @endphp
                            @endforeach
                        @else
                        <p>No Charges Found</p>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection @section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#categories-table').DataTable({
            responsive: true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        });

    });
</script>
@endsection