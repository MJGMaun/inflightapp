@extends('admin.layouts.app')
@section('content')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Movies</h1>
        </div>

        <a class="btn btn-sm btn-primary" href="/admin/movies/create">
                <span data-feather="plus"></span>
                Add Movie
        </a>

@endsection