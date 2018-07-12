@extends('admin.layouts.app') @section('css')
<style>
    #alert-boxes{
        position: fixed;
        bottom: 5%;
        right: 5%;
        z-index: 999;
        }
</style>
@endsection @section('content')

<a href="javascript:history.go(-1)" class="btn btn-sm btn-primary">
    <span data-feather="arrow-left"></span>
    Back
</a>
<br>
<br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Upload Scratch Cards</h1>
</div>

{!! Form::open(['action' => 'Admin\ScratchCardsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="col-md-6">
        {{Form::label('csv_file', 'CSV File')}}
        <br> {{Form::file('csv_file')}}
    </div>
    <div class="col-md-3 col-sm-3">
        {{-- {{Form::label('playsNeeded', 'Plays Needed')}} {{Form::number('playsNeeded', '', ['class' => 'form-control', 'min' => '0', 'placeholder' => 'Enter Value'])}} --}}<br>
        <button id="upload_csv" type="button" class="btn btn-outline-primary">Upload CSV</button>
    </div>
</div>
<br>
<div id="tableCSV">
</div> <br>
<div class="form-group">
    {{Form::submit('Save', ['class' => 'btn btn-success '])}} {!! Form::close() !!}
    <a class="btn btn-light ">
        Cancel
    </a>
</div>

<div id="alert-boxes">
</div>

@endsection @section('script')
    <script>
        $(".reveal").on('click',function() {
            var $pwd = $(".pwd");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });


        //CSV TO TEXTBOX
        const uploadCSV = document.getElementById('upload_csv');
        uploadCSV.addEventListener('click', e => {
        var fileUpload = document.getElementById("csv_file");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv)$/;
            if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof(FileReader) != "undefined") {
                var reader = new FileReader();
                reader.onload = function(e) {
                var table = document.createElement("table");
                table.setAttribute("id", "tableCSVaccounts");
                var rows = e.target.result.split("\n");
                // for (var i = 0; i < 1; i++) {
                //   var row = table.insertRow(-1);
                //   var cells = rows[i].split(",");
                //   for (var j = 0; j < cells.length - 1; j++) {
                    //     var cell = row.insertCell(-1);
                //     var replaced = cells[j].replace(/[^a-z0-9\s]/gi, '');
                //     var value = $.trim(replaced);
                //     cell.innerHTML = '<input type="text" id="row' + i + 'cell' + j + '" class="row' + i + '" value="' + value + '" disabled="disabled">';
                //   }
                // }
                for (var i = 1; i < rows.length - 1; i++) {
                    var row = table.insertRow(-1);
                    var cells = rows[i].split(",");
                    for (var j = 0; j < cells.length; j++) {
                    var cell = row.insertCell(-1);
                    var value = cells[j].trim();
                    // var replaced = cells[j].replace(/[^a-z0-9\s]/gi, '');
                    // var value = $.trim(replaced);
                    
                    if (value.length == 0) {
                        $(this).remove();
                    } else if(j == 0){
                        cell.innerHTML = '<input type="number" name="amount[]" value="' + value + '" readonly>';
                        
                    } else if(j == 1){
                        cell.innerHTML = '<input type="password" name="code[]" value="' + value + '" readonly>';
                        
                    } else if(j == 2){
                        cell.innerHTML = '<input type="password" name="pin[]" value="' + value + '" readonly>';
                        
                    } else if(j == 3){
                        cell.innerHTML = '<input type="date" name="card_expiration[]" value="' + value + '" readonly>';
                        
                    } else if(j == 4){
                        cell.innerHTML = '<input type="number" name="card_validity[]" value="' + value + '" readonly>';
                        
                    } else {
                        $(this).remove();
                    }
                    }
                }
                var dvCSV = document.getElementById("tableCSV");
                dvCSV.innerHTML = "";
                dvCSV.appendChild(table);
                $('#alert-boxes').append('<div class="alert alert-info alert-dismissable"> CSV file has been loaded.</div>');
                $('.alert-info').delay(4000).fadeOut('slow');
                }
                reader.readAsText(fileUpload.files[0]);
                $("#uploadFirebaseA").show();
            } else {
                $('#alert-boxes').append('<div class="alert alert-danger alert-dismissable">  This browser doesn\'t support HTML5</div>');
                $('.alert-danger').delay(4000).fadeOut('slow');
            }
            } else {
            $('#alert-boxes').append('<div class="alert alert-danger alert-dismissable">  Please upload a valid CSV file. </div>');
            $('.alert-danger').delay(4000).fadeOut('slow');
            }
        });
    </script>
@endsection