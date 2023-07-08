@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-5">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr class="bg-gray-51 border-b border-gray-200">
                        <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">شناسه</th>
                        <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">عنوان </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-201">
                    @foreach($categories as $category)
                        <tr>
                            <td class="px-7 py-4 whitespace-nowrap">{{$category->id}}</td>
                            <td class="px-7 py-4 whitespace-nowrap">{{$category->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection