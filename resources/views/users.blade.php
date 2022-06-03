<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users |  สวัสดี {{Auth::user()->name}} 
            <b class="text-right">จำนวนผู้ใช้ระบบ <span>{{count($users)}}</span></b>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="w-full">
                    <tr class="w-1/2 bg-indigo-300">
                        <th class="p-2 w-2/3">#</th>
                        <th class="p-2 text-center">Name</th>
                        <th class="p-2 text-center pr-4">Email</th>
                        <th class="p-2 text-center pr-4">Create at</th>
                    </tr>
                    @php($i=1)
                    @foreach($users as $row)
                    <tr class="">
                        <td class="p-2 text-center">{{$i++}}</td>
                        <td class="p-2 text-center text-green-600">{{$row->name}}</td>
                        <td class="p-2 text-center">{{$row->email}}</td>
                        <td class="text-center">
                     
                        {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                        </td>
                    </tr>
                    @endforeach
                   
                </table>
            </div>
        </div>
    </div>
</x-app-layout>