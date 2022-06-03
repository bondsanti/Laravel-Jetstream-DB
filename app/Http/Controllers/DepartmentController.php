<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department; //Eloquent
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; //Query Builder

class DepartmentController extends Controller
{
    function index(){
        //Eloquent
        //$departments = Department::all();
        $departments = Department::paginate(5);
        $trash = Department::onlyTrashed()->paginate(5);

        //Query Builder
        // $departments = DB::table('departments')->get();
        // $departments = DB::table('departments')->paginate(3);
        // $departments = DB::table('departments')
        // ->join('users','departments.ref_user_id','users.id')
        // ->select('departments.*','users.name')
        // ->paginate(5);

      

        return view("admin.department.index",compact('departments','trash'));

    }
    function insert(Request $request){
        // dd($request->department_name);
        //ตรวจสอบข้อมูล
        $request->validate(
            [
            'department_name'=>'required|unique:departments|max:20'
            ],
            [
                'department_name.required'=>"กรุณาป้อนข้อมูล",
                'department_name.max'=>"ต้องไม่เกิน 20 ตัวอักษร",
                'department_name.unique'=>"ข้อมูลซ้ำ"
            ]
        );
        //บันทึกข้อมูลแบบ Eloquent
        $department = new Department;
        $department->ref_user_id = Auth::user()->id;
        $department->department_name = $request->department_name;
        $department->save();
        
        return redirect()->back()->with('success','บันทึกข้อมูลสำเร็จ');

        //บันทึกข้อมูลแบบ Query Builder
        // $data = array();
        // $data["department_name"] = $request->department_name;
        // $data["ref_user_id"] = Auth::user()->id;
        // DB::table('departments')->insert($data);
        // return redirect()->back()->with('success','บันทึกข้อมูลสำเร็จ');

    }
    function edit($id){
        // $departments = DB::table('departments')
        // ->join('users','departments.ref_user_id','users.id')
        // ->select('departments.*','users.name')
        // ->paginate(5);
        //dd($id);
        //แก้ไขข้อมูล แบบ Eloquent
        $departments = Department::paginate(5);
        $edit_department = Department::find($id);
        //dd($department->department_name);
         return view("admin.department.edit",compact('departments','edit_department'));
    }

    function update(Request $request,$id){
        // dd($id,$request->department_name);
        $request->validate(
            [
            'department_name'=>'required|unique:departments|max:20'
            ],
            [
                'department_name.required'=>"กรุณาป้อนข้อมูล",
                'department_name.max'=>"ต้องไม่เกิน 20 ตัวอักษร",
                'department_name.unique'=>"ข้อมูลซ้ำ"
            ]
        );

        $update_department = Department::find($id)->update(
            [
                'department_name'=>$request->department_name,
                'ref_user_id'=>Auth::user()->id
            ]
            );
            return redirect()->route('department')->with('success','แก้ไขข้อมูลสำเร็จ');
    }
    function softdel($id){
        // dd($id);
      //ลบข้อมูล แบบ Eloquent
      $softdel_department = Department::find($id)->delete();
      return redirect()->route('department')->with('success','ย้ายไปถังขยะสำเร็จ');
    }
    function restore($id){
        $restore_department = Department::withTrashed()->find($id)->restore();
        return redirect()->route('department')->with('success','กู้ข้อมูลสำเร็จ');

    }
    function del($id){
        $del_department = Department::onlyTrashed()->find($id)->forceDelete();
        return redirect()->route('department')->with('success','ลบข้อมูลสำเร็จ');
    }
}
