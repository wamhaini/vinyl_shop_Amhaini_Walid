@extends('layouts.template')

@section('title', 'Edit user')

@section('main')
    <h1>Edit user: {{ $user->name }}</h1>
    <form action="/admin/users/{{$user->id}}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Name"
                   required
                   value="{{ old('name', $user->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email"
                   required
                   value="{{ old('email', $user->email) }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="from-group">
            <input type="checkbox" name="active" value="{{ old('active', $user->active) }}" {{$user->active == true ? 'checked': ' ' }}><label for="active">Active</label>
            <input type="checkbox" name="admin" value="{{ old('admin', $user->admin) }}" {{$user->admin == true ? 'checked': ' ' }}><label for="admin">Admin</label>
        </div>
        <button type="submit" class="btn btn-success">Save user</button>
    </form>
@endsection
