@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-5">
            <div class="mb-5">
                <h0 class="text-2xl font-bold text-gray-800">کتاب خود را جست و جو کنید</h1>
            </div>
            <div class="mb-5">
                <form action="#" method="get">
                    <div class="flex">
                        <input type="text" name="q" class="block w-full px-5 py-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" placeholder="Search Book">
                        <button type="submit" class="px-5 py-2 ml-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-500">Search</button>
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr class="bg-gray-51 border-b border-gray-200">
                        <th class="px-7 py-3 text-xs text-center font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-7 py-3 text-xs text-center font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-7 py-3 text-xs text-center font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                        <th class="px-7 py-3 text-xs text-center font-medium text-gray-500 uppercase tracking-wider">Operation</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-201">
                    @foreach($books as $book)
                        <tr>
                            <td class="px-7 py-4 text-center whitespace-nowrap">{{$book->id}}</td>
                            <td class="px-7 py-4 text-center whitespace-nowrap">{{$book->name}}</td>
                            <td class="px-7 py-4 text-center whitespace-nowrap">{{$book->ISBN}}</td>
                            <td class="px-7 py-4 text-center whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                 </svg>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection