<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SmStudentProgrammeCurriculum;
use App\Models\SmSupervisors;
use Illuminate\Support\Facades\Session;


class LoginAdminController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = [];
       
       
        if($request->post())
        {
           // echo "<pre>";
           $request->validate([
            'payroll_no' => 'required',
            'password'=>'required'
            ]);
           
            $payroll = $request->get('payroll_no');

            $data = SmSupervisors::where('payroll_number', $payroll)
            ->orderBy('id', 'desc')
            ->get();
            if($data->count() > 0)
            {
                foreach ($data as $row) {
                    session(['student_id' => ""]);
                    session(['role' => 'admin']);
                   // print_r($row);
                }
                Session::flash('message','Logged in Successfully.');
                Session::flash('alert-class', 'alert-success');
                return redirect("dashboard");

            }else{
                Session::flash('message','Incorrect details.');
                Session::flash('alert-class', 'alert-danger');
            }
        
        }

        return view('dashboard.loginadmin', $data);
    }

}