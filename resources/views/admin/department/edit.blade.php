<x-app-layout>
    <script>
    @if(Session::has('success'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.success("{{ session('success') }}");
    @endif
    </script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Department | สวัสดี {{Auth::user()->name}}

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container bg-white">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mt-3 mb-3">
                        <div class="card-header">
                            ตารางข้อมูล
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Department Name</th>
                                        <th scope="col">User Created</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($departments as $row)
                                    <tr>
                                        <th scope="row">{{$departments->firstItem()+$loop->index}}</th>
                                        <td>{{$row->department_name}}</td>
                                       
                                        <td>{{$row->ref_user->name}}</td>
                                        <td>@if($row->created_at==null)
                                                -
                                            @else
                                            {{$row->created_at}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/department/edit/'.$row->id)}}" role="button" class="btn btn-warning">Edit</a>
                                            <a href="{{url('/department/softdel/'.$row->id)}}" role="button" class="btn btn-secondary">Trash</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                           {{$departments->links()}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mt-3 mb-3">
                        <div class="card-header">
                            ฟอร์ม
                        </div>
                        <div class="card-body">
                            <form action="{{url('/department/update/'.$edit_department->id)}}" method="post">
                                @csrf
                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">ชื่อแผนก</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-danger" name="department_name" value="{{$edit_department->department_name}}">
                                        @error('department_name')
                                        <div class="mt-1"><span class="text-danger">{{$message}}</span></div>

                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-outline-success mt-4 mb-2">แก้ไขข้อมูล</button>
                                    <a href="{{url('department')}}" type="button" class="btn btn-info">กลับ</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>