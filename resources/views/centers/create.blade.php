@extends('layouts.reception')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Add New Center</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-4 shadow-sm">
        <form action="{{ route('centers.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Center Name</label>
                <input type="text" name="name" class="form-control" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Location (optional)</label>
                <input type="text" name="location" class="form-control">
                @error('location') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Add Center</button>
        </form>
    </div>

</div>
@endsection
