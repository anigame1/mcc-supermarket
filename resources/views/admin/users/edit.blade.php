@extends('layouts.app')

@section('title', 'Update User | MCC Supermarket')
@section('page-title', 'UPDATE USER')

@section('content')
<h3 class="mb-4">✏️ Update User Details</h3>

<form method="post" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" style="max-width:500px;">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current password">
    </div>

    <div class="mb-3">
        <label class="form-label">Profile Image</label><br>
        <img src="{{ $user->avatarUrl() }}" width="100" height="100" class="rounded mb-2" alt="Profile Image">
        <input type="file" name="avatar" class="form-control" accept="image/*">
        <small class="text-muted">Upload new image (optional)</small>
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
