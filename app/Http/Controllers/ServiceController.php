<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;//Eloquent
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 

class ServiceController extends Controller
{
    //

    function index(){
       $services = Service::paginate(5);
       return view('admin.service.index',compact('services'));
    }

    function insert(Request $request){
  
        //ตรวจสอบข้อมูล
        $request->validate(
            [
            'service_name'=>'required|unique:services|max:20',
            'service_img'=>'required|mimes:jpg,jpeg,png,gif'
            ],
            [
                'service_name.required'=>"กรุณาป้อนชื่อการบริการ",
                'service_name.max'=>"ต้องไม่เกิน 20 ตัวอักษร",
                'service_name.unique'=>"ข้อมูลซ้ำ",
                'service_img.required'=>"กรุณาเลือกรูปภาพ",
                'service_img.mimes'=>"jpg,jpeg,png,gif เท่านั้น!!",
            ]
        );
       
        //การเข้ารหัสภาพ
        $service_img = $request->file("service_img");
        //gen ชื่อภาพใหม่
        $name_gen=hexdec(uniqid());
        //ดึงนามสกุลไฟล์
        $img_ext = strtolower($service_img->getClientOriginalExtension());
        $nameImg = $name_gen.'.'.$img_ext;

        //อัพโหลดและบันทึกข้อมูล
        $upload_loc = 'image/services/';
        $full_path = $upload_loc.$nameImg;
        $service_img->move($upload_loc,$nameImg );

        Service::insert([
            'service_name'=>$request->service_name,
            'service_img'=>$full_path,
            'created_at'=>Carbon::now()
        ]);


        return redirect()->back()->with('success','บันทึกข้อมูลสำเร็จ');

    }
    function edit($id){

        //แก้ไขข้อมูล แบบ Eloquent
        $services = Service::paginate(5);
        $edit_service = Service::find($id);
       
         return view("admin.service.edit",compact('services','edit_service'));
    }
    function update(Request $request,$id){
        $request->validate(
            [
            'service_name'=>'required|max:20',
            'service_img'=>'mimes:jpg,jpeg,png,gif'
            ],
            [
                'service_name.required'=>"กรุณาป้อนชื่อการบริการ",
                'service_name.max'=>"ต้องไม่เกิน 20 ตัวอักษร",
                'service_img.mimes'=>"jpg,jpeg,png,gif เท่านั้น!!",
            ]
        );




        //การเข้ารหัสภาพ
        $service_img = $request->file("service_img");


        if($service_img){
            //gen ชื่อภาพใหม่
            $name_gen=hexdec(uniqid());
            //ดึงนามสกุลไฟล์
            $img_ext = strtolower($service_img->getClientOriginalExtension());
            $nameImg = $name_gen.'.'.$img_ext;

            //อัพโหลดและบันทึกข้อมูล
            $upload_loc = 'image/services/';
            $full_path = $upload_loc.$nameImg;
            $service_img->move($upload_loc,$nameImg );
            
            $updata_service = Service::find($id)->update(
                [
                    'service_name'=>$request->service_name,
                    'service_img'=>$full_path,
                    'updated_at'=>Carbon::now()
                ]
                );
                unlink($request->old_img);
        }else{

            $updata_service = Service::find($id)->update(
                [
                    'service_name'=>$request->service_name,
                    'service_img'=>$request->old_img,
                    'updated_at'=>Carbon::now()
                ]
                );

        }


            return redirect()->route('service')->with('success','แก้ไขข้อมูลสำเร็จ');
    }
    function del($id){
        $del_img = Service::find($id)->service_img;
        $del_service = Service::find($id)->delete();
        
        unlink($del_img);
        return redirect()->route('service')->with('success','ลบข้อมูลสำเร็จ');
    }


}