<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use DB;
class ScheduleApiController extends Controller
{
    public function store_template(Request $request){
        DB::table('template')->insert([
            'template_name'=>$request->template_name,
            'template_type'=>$request->template_type,
            'template_json'=>$request->template_json
        ]);
        return response(null,200);
    }
    public function update_template(Request $request){
        DB::table('template')
        ->where('id',$request->id)
        ->update([
            'template_name'=>$request->template_name,
            'template_json'=>$request->template_json
        ]);
        return response(null,200);
    }
    public function delete_template(Request $request){
        DB::table('template')
        ->where('id',$request->id)
        ->update([
            'status'=>'Y'
        ]);
        return response(null,200);
    }
    public function load_template(Request $request){
        $data=DB::table('template')->where('status','N')->get();
        return response($data,200);
    }

    public function store_template_job_duty(Request $request){
        DB::table('template_job_duty')->insert([
            'template_id'=>$request->template_id,
            'template_job_duty_name'=>$request->template_job_duty_name,
            'template_json'=>$request->template_json
        ]);
        return response(null,200);
    }
    public function update_template_job_duty(Request $request){
        DB::table('template_job_duty')->where('id',$request->template_id)->update([
            'template_job_duty_name'=>$request->template_job_duty_name,
            'template_json'=>$request->template_json
        ]);
        return response(null,200);
    }
    public function load_template_job_duty(Request $request){
       $data= DB::table('template_job_duty')
       ->join('template','template.id','=','template_job_duty.template_id')
       ->where('template_job_duty.status','N')
       ->select('template_job_duty.*','template.template_type','template.template_name')
       ->get();
        return response($data,200);
    }
    public function store_time_table(Request $request){
        DB::table('time_table')->insert([
            'date_range'=>$request->date_range,
            'time_table_name'=>$request->time_table_name,
            'job_json'=>$request->job_json
        ]);
        return response(null,200);
    }
}
