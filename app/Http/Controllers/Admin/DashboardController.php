<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\Driver;
use App\Models\UserB;
use App\Models\Trip;
use App\Models\CfServiceDetail;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    /*
    *  Display dashboard for admin panel
    */
    public function dashboard()
    {
        $page_title = __('Tổng quan BUTL');

        $current_user 	= auth()->user();


        if($current_user['id']==1)
        {
            $go_info_count = Trip::count();
            $taixe_count = Driver::count();
            $khachhang_count = UserB::count();
            $service_count = CfServiceDetail::count();
            $users_query = UserB::selectRaw('CONCAT_WS("-", MONTHNAME(create_time),YEAR(create_time)) monthyear, count(*) data');
            $users = $users_query->groupBy('monthyear')->orderBy('create_time', 'asc')->get();
            $users_monthyear = $users->pluck('monthyear');
            $users_count = $users->pluck('data');
            $max_user_count = max($users_count->toArray());
            $max_user_count = ($max_user_count <= 1) ? $max_user_count + 3 : $max_user_count + 1 ;
            return view('admin.dashboard',compact('go_info_count','taixe_count','khachhang_count','service_count','users_monthyear','users_count','max_user_count','page_title'));

        }
        else
        {
            $accountname   =  $current_user['first_name'] .' '.$current_user['name'];
            return view('admin.users.welcome',compact('accountname'));

        }

    }
}
