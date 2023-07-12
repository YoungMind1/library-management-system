@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Take Back Book!</h1>
        <form action="{{ route('admin.lends.take-back') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 font-bold mb-2">User id</label>
                <input type="name" name="user_id" id="user_id" class="form-input rounded-md shadow-sm border-gray-300" value="{{ old('user_id') }}" required autofocus>
                @error('user_id')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
                <label for="copy_id" class="block text-gray-700 font-bold mb-2">Copy id</label>
                <input type="name" name="copy_id" id="copy_id" class="form-input rounded-md shadow-sm border-gray-300" value="{{ old('copy_id') }}" required autofocus>
                @error('copy_id')
                    <p class="text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Take Back!
                </button>
                <a href="{{ route('admin.lends.index') }}" class="text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

