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
                                        <th scope="col">Name</th>
                                        <th scope="col">Images</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($services as $row)
                                    <tr>
                                        <th scope="row">{{$services->firstItem()+$loop->index}}</th>
                                        <td>{{$row->service_name}}</td>

                                        <td><img src="{{asset($row->service_img)}}" class="img-thumbnail" width="170px">
                                        </td>
                                        <td>{{$row->created_at}}</td>

                                        <td>
                                            <a href="{{url('/service/edit/'.$row->id)}}" role="button"
                                                class="btn btn-warning">Edit</a>
                                            <a href="{{url('/service/del/'.$row->id)}}" role="button"
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$services->links()}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mt-3 mb-3">
                        <div class="card-header">
                            ฟอร์มแก้ไข
                        </div>
                        <div class="card-body">
                            <form action="{{url('/service/update/'.$edit_service->id)}}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">ชื่อการบริการ</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-danger" name="service_name"
                                            value="{{$edit_service->service_name}}">
                                        @error('service_name')
                                        <div class="mt-1"><span class="text-danger">{{$message}}</span></div>

                                        @enderror
                                    </div>
                                    <div class="mt-3"><span>รูปเดิม</span> <img
                                            src="{{asset($edit_service->service_img)}}" class="img-thumbnail"
                                            width="170px"></div>
                                    <label for="staticEmail" class="col-sm-4 col-form-label">รูปใหม่</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control" name="service_img" value="">
                                        @error('service_img')
                                        <div class="mt-1"><span class="text-danger">{{$message}}</span></div>

                                        @enderror
                                    </div>
                                    <div class="d-grid gap-2 d-md-block mt-4">
                                        <button type="submit" class="btn btn-outline-success">บันทึก</button>
                                        <a href="{{url('service')}}" role="button" class="btn btn-info">กลับ</a>
                                    </div>
                                </div>

                                <input type="hidden" name="old_img" value="{{$edit_service->service_img}}">

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>