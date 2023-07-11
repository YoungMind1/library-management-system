@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Edit User</h1>
        <form action="{{ route('admin.users.update', $user) }}" method="" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">name</label>
                <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm border-gray-300" value="{{ old('name') ?? $user->name }}" required autofocus>
                @error('name')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="text" name="email" id="email" class="form-input rounded-md shadow-sm border-gray-300" value="{{ old('email') ?? $user->email }}" required>
                @error('email')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-bold mb-2">Phone</label>
                <input type="text" name="phone" id="phone" class="form-input rounded-md shadow-sm border-gray-300" value="{{ old('phone') ?? $user->phone }}" required>
                @error('phone')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create
                </button>
                <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
