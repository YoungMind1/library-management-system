@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row">
            <!-- User Details -->
            <div class="w-full md:w-2/3 md:pl-8">
                <h1 class="text-2xl font-bold mb-2">Name: {{$user->name}}</h1>
                <p class="text-gray-700 mb-4">Email: {{$user->email}}</p>
                <p class="text-gray-700 mb-4">Is Email Verified?: {{is_null($user->email_verified_at) ? "NO" : "YES"}}</p>
                <p class="text-gray-700 mb-4">Phone: {{$user->phone}}</p>
                <p class="text-gray-700 mb-4">Is Phone Verified?: {{is_null($user->phone_verified_at) ? "NO" : "YES"}}</p>
            </div>
        </div>
    </div>
@endsection
