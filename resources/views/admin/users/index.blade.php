@extends('layouts.app')

@section('title', 'Manage Users | MCC Supermarket')
@section('page-title', 'MANAGE USERS')

@section('content')
<h2 class="text-center my-4">User List</h2>

<table class="table table-striped table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Profile Image</th>
            <th>Operations</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><img src="{{ $user->avatarUrl() }}" style="width:60px;height:60px;object-fit:cover;border-radius:50%;border:2px solid #ccc;" alt="User Image"></td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm text-light">Update</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
