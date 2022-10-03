<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use DB;
// use App\Model\Basic\account;
// use App\Model\Basic\pages;
// use App\Model\view_table;
class LoginApiController extends Controller
{
    // public function custom_login(Request $request){
    //     $user_id=$request->user_id;
    //     $password=$request->password;
    //     $data=account::login_check($user_id,$password);
    //     if($data!=null){
    //         $page=view_table::query_user_page_pages_filter_by_user_id($user_id); 
    //         $all_page=pages::query_all_pages();
    //         return response(['account'=>$data,'page'=>$page,'all_page'=>$all_page], 200);
    //     }else{
    //         return response('登入失敗', 500);
    //     }
    // }
}
