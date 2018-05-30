@extends('admin.layouts.app')
@section('content')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Movies</h1>
        </div>

        <a class="btn btn-sm btn-primary" href="/admin/movies/create">
                <span data-feather="plus"></span>
                Add Movie
        </a>


        <table id="movies-table" class="table table-bordered table-striped" style="width: 100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
              </tr>
            </thead>
            <tbody>
              @foreach($movies as $movie)
              <tr>
                <td>{{$movie->id}}</td>
                <td>{{$movie->lastName}}</td>
                <td>{{$movie->firstName}}</td>
                <td>{{$movie->middleName}}</td>
                <td>{{$movie->email}}</td>
                <td>{{$movie->created_at}}</td>
                <td>{{$movie->updated_at}}</td>
              </tr>
              @endforeach
            </tbody>
        </table>

@endsection

@section('script')
        <script type="text/javascript">
                $(document).ready(function() {
                    $('#movies-table').DataTable( {
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    } );
                } );
        </script>
@endsection