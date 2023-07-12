@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-5">
            <!-- <div class="mb-5">
                <h0 class="text-2xl font-bold text-gray-800">کتاب خود را جست و جو کنید</h1>
            </div> -->
            <div class="mb-5">
                <form action="{{route('admin.users.index')}}" method="get">
                    <div class="flex">
                        <input type="text" name="query" class="block w-full px-5 py-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" placeholder="Search Book ...">
                        <button type="submit" class="px-5 py-2 ml-2 text-white bg-indigo-500 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-500">Search</button>
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-51 border-b border-gray-200">
                            <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-7 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Operation</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-201">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-7 py-4 text-center whitespace-nowrap">{{$user->id}}</td>
                                <td class="px-7 py-4 text-center whitespace-nowrap">{{$user->name}}</td>
                                <td class="px-7 py-4 text-center whitespace-nowrap">{{$user->email}}</td>
                                <td class="px-7 py-4 text-center whitespace-nowrap">{{$user->phone}}</td>
                                <td class="px-7 py-4 whitespace-nowrap">
                                    <form action="{{route('admin.users.destroy', $user->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="">
                                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20" height="20" viewBox="0 0 256 256" xml:space="preserve">
                                                <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                                                    <path d="M 73.771 19.39 c -0.378 -0.401 -0.904 -0.628 -1.455 -0.628 H 17.685 c -0.551 0 -1.077 0.227 -1.455 0.628 c -0.378 0.4 -0.574 0.939 -0.542 1.489 l 3.637 62.119 C 19.555 86.924 22.816 90 26.75 90 h 36.499 c 3.934 0 7.195 -3.076 7.427 -7.003 l 3.637 -62.119 C 74.344 20.329 74.148 19.79 73.771 19.39 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(50,94,183); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                    <path d="M 78.052 14.538 H 11.948 c -1.104 0 -2 -0.896 -2 -2 s 0.896 -2 2 -2 h 66.104 c 1.104 0 2 0.896 2 2 S 79.156 14.538 78.052 14.538 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(50,94,183); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                    <path d="M 57.711 14.538 H 32.289 c -1.104 0 -2 -0.896 -2 -2 V 7.36 c 0 -4.059 3.302 -7.36 7.36 -7.36 h 14.703 c 4.058 0 7.359 3.302 7.359 7.36 v 5.178 C 59.711 13.643 58.815 14.538 57.711 14.538 z M 34.289 10.538 h 21.422 V 7.36 c 0 -1.853 -1.507 -3.36 -3.359 -3.36 H 37.649 c -1.853 0 -3.36 1.507 -3.36 3.36 V 10.538 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(50,94,183); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                    <path d="M 57.342 76.103 c -0.039 0 -0.079 -0.001 -0.119 -0.004 c -1.103 -0.064 -1.944 -1.011 -1.879 -2.113 l 2.29 -39.113 c 0.063 -1.103 0.993 -1.952 2.113 -1.88 c 1.103 0.064 1.944 1.011 1.88 2.113 L 59.336 74.22 C 59.274 75.282 58.393 76.103 57.342 76.103 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                    <path d="M 32.658 76.103 c -1.051 0 -1.933 -0.82 -1.995 -1.883 l -2.29 -39.114 c -0.064 -1.103 0.777 -2.049 1.88 -2.113 c 1.088 -0.062 2.049 0.777 2.113 1.88 l 2.29 39.113 c 0.064 1.103 -0.777 2.049 -1.88 2.113 C 32.737 76.102 32.698 76.103 32.658 76.103 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                    <path d="M 45 76.103 c -1.104 0 -2 -0.896 -2 -2 V 34.989 c 0 -1.104 0.896 -2 2 -2 s 2 0.896 2 2 v 39.114 C 47 75.207 46.104 76.103 45 76.103 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                </g>
                                            </svg>
                                        </button>
                                    </form>
                                    <a class="inline-block" href="{{route('admin.users.show', $user)}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                    <a class="inline-block" href="{{route('admin.users.edit', $user)}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20" height="20" viewBox="0 0 256 256" xml:space="preserve">
                                            <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
                                                <path d="M 85.155 89.979 c -0.425 0 -0.855 -0.056 -1.282 -0.17 l -19.906 -5.334 c -0.373 -0.1 -0.731 -0.243 -1.067 -0.426 l -0.143 0.137 l -2.656 -2.608 l 21.456 -21.457 l 1.45 1.45 c 0.73 0.639 1.244 1.459 1.489 2.377 l 5.334 19.905 c 0.455 1.699 -0.015 3.454 -1.258 4.698 C 87.641 89.482 86.422 89.979 85.155 89.979 z M 64.392 81.483 c 0.108 0.052 0.222 0.095 0.343 0.127 l 19.907 5.334 c 0.954 0.259 1.598 -0.258 1.831 -0.491 c 0.233 -0.233 0.747 -0.877 0.491 -1.831 L 81.63 64.716 c -0.032 -0.12 -0.074 -0.234 -0.129 -0.342 L 64.392 81.483 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                                <path d="M 55.935 77.412 L 3.789 25.266 c -5.052 -5.051 -5.052 -13.271 0 -18.322 l 3.134 -3.134 c 5.052 -5.052 13.272 -5.052 18.322 0 l 52.146 52.146 L 55.935 77.412 z M 16.084 2.986 c -2.558 0 -5.116 0.973 -7.064 2.921 L 5.886 9.041 c -3.895 3.895 -3.895 10.232 0 14.127 l 50.049 50.049 l 17.261 -17.262 L 23.148 5.907 C 21.2 3.96 18.642 2.986 16.084 2.986 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                                            </g>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$users->links()}}
            </div>
        </div>
    </div>
@endsection
