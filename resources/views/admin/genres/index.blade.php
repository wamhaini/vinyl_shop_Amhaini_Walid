@extends('layouts.template')

@section('title', 'Genres')

@section('main')
    <h1>Genres</h1>
    @include('shared.alert')
    <p>
        <a href="/admin/genres/create" class="btn btn-outline-success">
            <i class="fas fa-plus-circle mr-1"></i>Create new genre
        </a>
    </p>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Genre</th>
                <th>Records for this genre</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($genres as $genre)
                <tr>
                    <td>{{ $genre->id }}</td>
                    <td>{{ $genre->name }}</td>
                    <td>{{ $genre->records_count }}</td>
                    <td>
                        <form action="/admin/genres/{{ $genre->id }}" method="post" class="deleteForm">
                            @method('delete')
                            @csrf
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/genres/{{ $genre->id }}/edit" class="btn btn-outline-success"
                                   data-toggle="tooltip"
                                   title="Edit {{ $genre->name }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger"
                                        data-toggle="tooltip"
                                        data-name="{{ $genre->name }}"
                                        data-records="{{ $genre->records_count }}"
                                        title="Delete {{ $genre->name }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@section('script_after')
    <script>
        $(function () {
            $('.deleteForm button').click(function () {
                let records = $(this).data('records');
                let name = $(this).data('name');
                let msg = `Delete the genre '${name}'?`;
                if (records > 0) {
                    msg += `\nThe ${records} '${name}' records of this genre will also be deleted!`
                }

                if(confirm(msg)) {
                    $(this).closest('form').submit();
                }
            })
        });
    </script>
@endsection
@endsection
