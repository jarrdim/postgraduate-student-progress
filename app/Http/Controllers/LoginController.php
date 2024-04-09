<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SmStudentProgrammeCurriculum;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = [];
       
       
        if($request->post())
        {
           // echo "<pre>";
           $request->validate([
            'regno' => 'required',
            'password'=>'required'
            ]);
           
            $regno = $request->get('regno');

            $data =  SmStudentProgrammeCurriculum::select(
                'sm_student_programme_curriculum.*',
                'sm_student_category.std_category_name',
                'sm_student.student_number',
                'sm_student_programme_curriculum.registration_number',
                'sm_student_programme_curriculum.student_id',
                'sm_student.surname',
                'sm_student.other_names',
                'sm_student.gender',
                'org_programme_curriculum.prog_curriculum_desc',
                'org_programme_curriculum.prog_id',
                'org_programme_curriculum.prog_curriculum_id',
                'org_programmes.prog_code',
                'org_programmes.prog_short_name',
                'org_programmes.prog_full_name',
                'org_programmes.prog_type_id',
                'org_prog_type.prog_type_name'
            )
            ->join('smisinterns.sm_student_category', 'sm_student_programme_curriculum.student_category_id', '=', 'sm_student_category.std_category_id')
            ->join('smisinterns.sm_student', 'sm_student_programme_curriculum.student_id', '=', 'sm_student.student_id')
            ->join('smisinterns.org_programme_curriculum', 'sm_student_programme_curriculum.prog_curriculum_id', '=', 'org_programme_curriculum.prog_curriculum_id')
            ->join('smisinterns.org_programmes', 'org_programme_curriculum.prog_id', '=', 'org_programmes.prog_id')
            ->join('smisinterns.org_prog_type', 'org_programmes.prog_type_id', '=', 'org_prog_type.prog_type_id')
            ->where('sm_student.student_number', $regno)
           //->get();
           ->pluck('sm_student.student_id');

  
            if($data->count() > 0)
            {
                foreach ($data as $row) {
                    session(['student_id' => $row]);
                    session(['role' => 'student']);
                   // print_r($row);
                }
                Session::flash('message','Logged in Successfully.');
                Session::flash('alert-class', 'alert-success');
                return redirect("dashboard/assignedSupervisors");
            }else{
                Session::flash('message','Incorrect details.');
                Session::flash('alert-class', 'alert-danger');
            }
        
        }

        return view('dashboard.login', $data);
    }

}