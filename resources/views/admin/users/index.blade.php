@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>
    <form method="get" action="/admin/users" id="searchForm">
        <div class="row">
            <div class="col-sm-7 mb-2">
                <label for="user">Filter Name Or Email</label>
                <input type="text" class="form-control" name="user" id="user"
                       value="{{ request()->user }}" placeholder="Filter Name Or Email">
            </div>
            <div class="col-sm-5 mb-2">
                <label for="sort">Sort by</label>
                <select class="form-control" name="sort" id="sort">
                    <option value="name_desc">Name (A &rArr; Z)</option>
                    <option value="name_asc">Name (Z &rArr; A)</option>
                    <option value="email_desc">Email (A &rArr; Z)</option>
                    <option value="email_asc">Email (Z &rArr; A)</option>
                    <option value="not_active">Not active</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
    </form>
    <hr>
    @if ($users->count() == 0)
        <div class="alert alert-danger alert-dismissible fade show">
            Can't find any name or email with <b>'{{ request()->name }}'</b>.
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    @if ($user->active == true)
                        <td><i class="fas fa-check"></i></td>
                    @else
                        <td></td>
                    @endif
                    @if ($user->admin == true)
                        <td><i class="fas fa-check"></i></td>
                    @else
                        <td></td>
                    @endif
                    <td data-id="{{$user->id}}" data-name="{{$user->name}}">
                        <div class="btn-group btn-group-sm">

                            @if(auth()->user()->name == $user->name)
                                <a href="/admin/users/{{ $user->id }}/edit"class="btn btn-outline-success btn-edit disabled" data-toggle="tooltip" title="Edit {{$user->name}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#!"class="btn btn-outline-danger btn-delete disabled" data-toggle="tooltip" title="Delete {{$user->name}}">
                                    <i class="fas fa-trash"></i>
                                </a>
                                @else
                                <a href="/admin/users/{{ $user->id }}/edit"class="btn btn-outline-success btn-edit" data-toggle="tooltip" title="Edit {{$user->name}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#!"class="btn btn-outline-danger btn-delete" data-toggle="tooltip" title="Delete {{$user->name}}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
@endsection
@section('script_after')
    <script>
        $('tbody').on('click', '.btn-delete', function () {
            // Get data attributes from td tag
            let id = $(this).closest('td').data('id');
            let name = $(this).closest('td').data('name');
            // Set some values for Noty
            let text = `<p>Delete the user <b>${name}</b>?</p>`;
            let type = 'warning';
            let btnText = 'Delete user';
            let btnClass = 'btn-success';
            // Show Noty
            let modal = new Noty({
                timeout: false,
                layout: 'center',
                modal: true,
                type: type,
                text: text,
                buttons: [
                    Noty.button(btnText, `btn ${btnClass}`, function () {
                        // Delete user and close modal
                        deleteUser(id);
                        modal.close();
                    }),
                    Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                        modal.close();
                    })
                ]
            }).show();
        });

        // Delete a user
        function deleteUser(id) {
            // Delete the user from the database
            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/users/${id}`, pars, 'json')
                .done(function (data) {
                    console.log('data', data);
                    // Show toast
                    new Noty({
                        type: data.type,
                        text: data.text
                    }).show();
                    // Rebuild the table
                    setTimeout(function () {
                        $(location).attr('href', '/admin/users'); // jQuery
                    }, 2000);
                })
                .fail(function (e) {
                    console.log('error', e);
                });
        }

        $(function () {
            // submit form when leaving text field 'user'
            $('#user').blur(function () {
                $('#searchForm').submit();
            });
            // submit form when changing dropdown list 'sort'
            $('#sort').change(function () {
                $('#searchForm').submit();
            });
        })
    </script>
@endsection
