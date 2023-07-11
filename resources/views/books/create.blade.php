<!-- resources/views/books/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">New Book</h1>
        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Title</label>
                <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm border-gray-300" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                <select name="category" id="category" class="form-select rounded-md shadow-sm border-gray-300" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" {{ old('category') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="ISBN" class="block text-gray-700 font-bold mb-2">ISBN</label>
                <input type="text" name="ISBN" id="ISBN" class="form-input rounded-md shadow-sm border-gray-300" value="{{ old('ISBN') }}" required>
                @error('ISBN')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Cover Image</label>
                <input type="file" name="image" id="image" class="form-input rounded-md shadow-sm border-gray-300" accept="image/*" required>
                @error('image')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create
                </button>
                <a href="{{ route('admin.books.index') }}" class="text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
