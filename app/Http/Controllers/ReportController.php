<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Upload;
use App\Models\ApprovalHistory;

class ReportController extends Controller
{
    //

    public function index(Request $request)
    {

        try{
        
            //NO. AND DATA OF ASSIGNED STUDENTS
            $NoOfStudentsAssigned = DB::table('smisinterns.bps_supervisor_student_ids')
            ->select('bps_supervisor_student_ids.student_id',
            'bps_supervisor_student_ids.id', 
            'bps_supervisor_student_ids.supervisor_id', 
            'bps_supervisor_student_ids.status', 
            'bps_supervisor_student_ids.created_at', 
            'bps_supervisor_student_ids.updated_at',
      
            'sm_student.other_names as student_name',
            'sm_admitted_student.primary_email as student_email',
            'sm_student_programme_curriculum.registration_number',

           // 'approvals_history.file_id'

            )
            ->join('smisinterns.sm_student', 'bps_supervisor_student_ids.student_id', '=', 'sm_student.student_id')
            ->join('smisinterns.um_employees', 'bps_supervisor_student_ids.supervisor_id', '=', 'um_employees.id')
            ->join('smisinterns.sm_student_programme_curriculum', 'sm_student_programme_curriculum.student_id', '=', 'bps_supervisor_student_ids.student_id')
            ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')

           // ->join('smisinterns.approvals_history', 'approvals_history', '=', )
    
            
    
            ->whereIn('bps_supervisor_student_ids.id', function ($query) {
                $query->select(DB::raw('MIN(bps_supervisor_student_ids.id)'))
                    ->from('smisinterns.bps_supervisor_student_ids')
                    ->groupBy('student_id'); 
            })
            ->get();
          
            if($NoOfStudentsAssigned->count() > 0)
            {
              $data['numberAssignedStudents'] = $NoOfStudentsAssigned->count();
              $data['assignedStudentData'] = $NoOfStudentsAssigned;
            }
            else
            {
              $data['numberAssignedStudents'] = "0";
              $data['assignedStudentData'] = "0";
            }
                }

            catch(\Exception $e)
            {
      
              //echo $e;
      
        
            }
        return view("dashboard.studentprogressreport", $data);
    }


    public function getProgressData(Request $request)
    {

        
        if ($request->ajax()) {
            $studentId = $request->get("student_id");
    
            try {

                $result = ApprovalHistory::select('smisinterns.approvals_history.*','bps_document_uploads.file','sm_student.student_number' )
                ->join('smisinterns.bps_document_uploads','bps_document_uploads.file_id', '=', 'approvals_history.file_id')
                ->join('smisinterns.sm_student', 'bps_document_uploads.student_id', '=', 'sm_student.student_id')
                ->where('bps_document_uploads.student_id', $studentId)
                
                ->orderBy('approvals_history.id', 'desc')
                ->get();
               

                
               $info = $result;
                return response()->json($info);
                
            } catch (\Exception $e) {
              
                return response()->json(['error' => $e->getMessage()]);
            }
        }

       
    }
}
