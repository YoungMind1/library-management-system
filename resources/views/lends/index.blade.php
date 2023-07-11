@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-5">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-51 border-b border-gray-200">
                            <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">User Name</th>
                            <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Book Name</th>
                            <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Returned?</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-201">
                        @foreach($records as $record)
                            <tr>
                                <td class="px-7 py-4 whitespace-nowrap">{{\App\Models\User::find($record->user_id)->name}}</td>
                                <td class="px-7 py-4 whitespace-nowrap">{{\App\Models\Copy::find($record->copy_id)->book->name}}</td>
                                <td class="px-7 py-4 whitespace-nowrap">{{$record->due_date}}</td>
                                <td class="px-7 py-4 whitespace-nowrap">{{$record->returned ? "YES": "NO"}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
