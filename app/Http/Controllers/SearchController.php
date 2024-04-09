<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SmStudentProgrammeCurriculum;
use App\Models\SmStudentCategory;

class SearchController extends Controller
{

 
    public function action(Request $request)
    {
        $output = "";
       
        if ($request->ajax()) {
            $query = strtoupper($request->get("query"));

           
            $response = array();
          
            if ($query != '') {
             
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
                ->where('sm_student.student_number', 'LIKE', '%' . $query. '%')
                ->orWhere('sm_student.other_names', 'LIKE', '%'. $query. '%')
                ->take(3)
                ->get();
            
                    
             
                $response['from'] = $data;
                $response['query'] = $query;
               
                if ($data->count() > 0) {
                    $output .= '';
                    foreach ($data as $row) {
                        $output .= '<tr>
                        <td class="text-bold">'.$row->student_number.'</td>
                        <td class="text-bold">'.$row->other_names.'</td>
                        <td class="text-bold">'.$row->prog_full_name.'</td>
                        <td class="text-bold">'.$row->std_category_name.'</td>
                        <td><a href="/dashboard/viewassigned/' . $row->student_id . '">View Assigned Supervisors</a></td>
                        
                        </tr>';
                    }
                    //<td><a style="background:orange;" href="viewassigned/' . $row->student_id . '" class="btn">View Assigned Supervisors</a></td>
                    $response['data'] = $output;
                } else {
                    $response['data'] = '<tr>

                    <td  colspan="5" class="text-center w-100" >NO RECORD FOUND</td>
                  
                    </tr>';
                }
    
                $response['status'] = 'yes';
            } else {
                $response['status'] = 'no';
            }
    //
    //$response['query'] =  $query;
           
            echo json_encode($response);
        }
    }
    

}
