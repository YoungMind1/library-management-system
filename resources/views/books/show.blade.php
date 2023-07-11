@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row">
            <!-- Book Thumbnail -->
            <div class="w-full md:w-1/3">
                <img src="{{asset($book->image?->path) ?? asset('img/default-book.png')}}" alt="Book Cover" class="w-full h-auto">
            </div>
            <!-- Book Details -->
            <div class="w-full md:w-2/3 md:pl-8">
                <h1 class="text-2xl font-bold mb-2">Name: {{$book->name}}</h1>
                <p class="text-gray-700 mb-4">{{ $book->categories->count() > 1 ? "Categories: " : "Category: "}}</p>
                <ul>
                    @foreach($book->categories as $category)
                    <li style="margin-left: 2rem">
                        {{$category->name}}
                    </li>
                    @endforeach
                    <br>
                </ul>
                <p class="text-gray-700 mb-4">ISBN: {{$book->ISBN}}</p>
                <p class="text-gray-700 mb-4">Published: {{$book->created_at}}</p>
            </div>
        </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr class="bg-gray-51 border-b border-gray-200">
                        <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">id</th>
                        <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">status</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-201">
                    @foreach($book->copies as $copy)
                        <tr>
                            <td class="px-7 py-4 whitespace-nowrap">{{$copy->id}}</td>
                            @role('admin')
                                <td class="px-7 py-4 whitespace-nowrap">{{$copy->status === App\Enums\CopyStatusEnum::BORROWERD ? "Currenly borrowerd by " . $copy->currentBorrower : 'Available'}}</td>
                            @else
                                <td class="px-7 py-4 whitespace-nowrap">{{$copy->status === App\Enums\CopyStatusEnum::BORROWERD ? "Currenly borrowerd" : 'Available'}}</td>
                            @endrole
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
    </div>
@endsection
