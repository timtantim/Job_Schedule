<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use DB;
class EmployeeApiController extends Controller
{
    public function load_employee(Request $request){
        $data=DB::table('employee')->get();
        return response($data,200);
    }
}
