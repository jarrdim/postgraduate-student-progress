<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\SmStudentProgrammeCurriculum;
use App\Models\SmSupervisors;
use App\Models\BpsSupervisorStudentId;

class CountController extends Controller
{
    
    public function dashboard(Request $req)
    {
      $data= [];
      $data['numberAssignedSuperisors'] ="0";
      $data['remainingSupervisors'] = "0";
      $data['numberAssignedStudents'] = "0";
      $data['notAssignedStudents'] = "0";
      $data['studentId'] ="";

  
      
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

        //'um_employees.other_names as supervisor_name',
        
        
        )
        ->join('smisinterns.sm_student', 'bps_supervisor_student_ids.student_id', '=', 'sm_student.student_id')
        ->join('smisinterns.um_employees', 'bps_supervisor_student_ids.supervisor_id', '=', 'um_employees.id')
        ->join('smisinterns.sm_student_programme_curriculum', 'sm_student_programme_curriculum.student_id', '=', 'bps_supervisor_student_ids.student_id')
        ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')

        

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



        //NUMBER OF UNASSIGNED STUDENTS
        $res = DB::table('smisinterns.bps_supervisor_student_ids')
        ->select('bps_supervisor_student_ids.student_id',
        'bps_supervisor_student_ids.id', 
        'bps_supervisor_student_ids.supervisor_id', 
        'bps_supervisor_student_ids.status', 
        'bps_supervisor_student_ids.created_at', 
        'bps_supervisor_student_ids.updated_at',
  
        'sm_student.other_names as student_name',
        'sm_admitted_student.primary_email as student_email',
        'sm_student_programme_curriculum.registration_number',
        
        )
        ->join('smisinterns.sm_student', 'bps_supervisor_student_ids.student_id', '=', 'sm_student.student_id')
        ->join('smisinterns.um_employees', 'bps_supervisor_student_ids.supervisor_id', '=', 'um_employees.id')
        ->join('smisinterns.sm_student_programme_curriculum', 'sm_student_programme_curriculum.student_id', '=', 'bps_supervisor_student_ids.student_id')
        ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')
        ->whereIn('bps_supervisor_student_ids.id', function ($query) {
            $query->select(DB::raw('MIN(bps_supervisor_student_ids.id)'))
                ->from('smisinterns.bps_supervisor_student_ids')
                ->groupBy('student_id'); 
        })
        ->pluck('student_id');


        $notAssignedStudents=  SmStudentProgrammeCurriculum::select(
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
          'org_prog_type.prog_type_name',

          'sm_admitted_student.primary_email',
          'sm_admitted_student.primary_phone_no',
      )
      ->join('smisinterns.sm_student_category', 'sm_student_programme_curriculum.student_category_id', '=', 'sm_student_category.std_category_id')
      ->join('smisinterns.sm_student', 'sm_student_programme_curriculum.student_id', '=', 'sm_student.student_id')
      ->join('smisinterns.org_programme_curriculum', 'sm_student_programme_curriculum.prog_curriculum_id', '=', 'org_programme_curriculum.prog_curriculum_id')
      ->join('smisinterns.org_programmes', 'org_programme_curriculum.prog_id', '=', 'org_programmes.prog_id')
      ->join('smisinterns.org_prog_type', 'org_programmes.prog_type_id', '=', 'org_prog_type.prog_type_id')
      ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')
      ->whereNotIn('sm_student.student_id', $res)
      ->get();

      if($notAssignedStudents->count() > 0)
      {
        $data['notAssignedStudents'] = $notAssignedStudents->count();
        $data['unassignedStudentData'] = $notAssignedStudents;
      }
      else{
        $data['notAssignedStudents'] = "0";
        $data['unassignedStudentData'] = "";

      }

   
     

        

        //ASSIGNED SUPERVISORS
        $NoOfAssignedSupervisors = DB::table('smisinterns.bps_supervisor_student_ids')
          ->select('bps_supervisor_student_ids.student_id',
          'bps_supervisor_student_ids.id', 
          'bps_supervisor_student_ids.supervisor_id', 
          'bps_supervisor_student_ids.status', 
          'bps_supervisor_student_ids.created_at', 
          'bps_supervisor_student_ids.updated_at',

          'sm_student.other_names as student_name',
          'sm_student.student_id',
          'sm_admitted_student.primary_email as student_email',
          'sm_student_programme_curriculum.registration_number',
          
          'um_employees.payroll_number',
          'um_employees.other_names as other_names',
          'um_employees.email',
          
          )
          ->join('smisinterns.sm_student', 'bps_supervisor_student_ids.student_id', '=', 'sm_student.student_id')
          ->join('smisinterns.um_employees', 'bps_supervisor_student_ids.supervisor_id', '=', 'um_employees.id')
          ->join('smisinterns.sm_student_programme_curriculum', 'sm_student_programme_curriculum.student_id', '=', 'bps_supervisor_student_ids.student_id')
          ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')
          ->whereIn('bps_supervisor_student_ids.id', function ($query) {
              $query->select(DB::raw('MIN(bps_supervisor_student_ids.id)'))
                  ->from('smisinterns.bps_supervisor_student_ids')
                  ->groupBy('supervisor_id'); 
          })
         
          ->get();
          
          if($NoOfAssignedSupervisors->count() > 0)
          {
        
            $data['numberAssignedSuperisors'] = $NoOfAssignedSupervisors->count();
            
          }
          else{
            
            $data['numberAssignedSuperisors'] = "0";
          }

      /**
       * ASSIGNED SUPERVISORS SORT BY SUPERVISORS AND STUDENTS
       * 
       */
  
 
 
        $assignments = DB::table('smisinterns.bps_supervisor_student_ids')
        ->select('smisinterns.bps_supervisor_student_ids.*', 'um_employees.other_names as supervisor_name')
        ->join('smisinterns.sm_student', 'bps_supervisor_student_ids.student_id', '=', 'sm_student.student_id')
        ->join('smisinterns.um_employees', 'bps_supervisor_student_ids.supervisor_id', '=', 'um_employees.id')
        ->get();

            $supervisors = [];
            foreach ($assignments as $assignment) {
                $supervisorId = $assignment->supervisor_id;
                $supervisorName = $assignment->supervisor_name;

                $updateAt = $assignment->updated_at;

                if (!isset($supervisors[$supervisorId])) {
                    $supervisors[$supervisorId] = [
                        'supervisor_id' => $supervisorId,
                        'supervisor_name' => $supervisorName,
                        'updated_at' => $updateAt,
                        'assigned_students' => [],
                    ];
                }

                $studentId = $assignment->student_id;
                $supervisors[$supervisorId]['assigned_students'][] = $studentId;

                
            }

            // Sort supervisors and their assigned students
            usort($supervisors, function ($a, $b) {
                return $a['supervisor_id'] - $b['supervisor_id'];
            });

            foreach ($supervisors as &$supervisor) {
                // Fetch detailed information for each assigned student
                foreach ($supervisor['assigned_students'] as &$studentId) {
                    // Fetch student information based on student_id
                    $studentInfo = []; // Replace with code to fetch student info based on $studentId
                    $studentInfo = DB::table('smisinterns.sm_student')
                    
                    ->where('student_id', $studentId)
                    ->get();

                    foreach($studentInfo as $row)
                    {
                      $studentId = $row;
                    }
                    //$studentInfo['student_id'] = $studentId;
                    //$studentId = $studentInfo;
                }
            }

            if( is_array($supervisors))
            {
              
              $data['AssignedSuperisors'] =$supervisors;
            }
            else
            {
              $data['AssignedSuperisors'] ="";
            }


        ///NO. OF NOT ASSIGNED SUPERVISORS

        $NotAssignedSupervisors = DB::table('smisinterns.bps_supervisor_student_ids')
        ->select('bps_supervisor_student_ids.student_id',
        'bps_supervisor_student_ids.id', 
        'bps_supervisor_student_ids.supervisor_id', 
        'bps_supervisor_student_ids.status', 
        'bps_supervisor_student_ids.created_at', 
        'bps_supervisor_student_ids.updated_at',

        'sm_student.other_names as student_name',
        'sm_admitted_student.primary_email as student_email',
        'sm_student_programme_curriculum.registration_number',
        
        'um_employees.payroll_number',
        'um_employees.other_names as other_names',
        'um_employees.email',
        
        )
        ->join('smisinterns.sm_student', 'bps_supervisor_student_ids.student_id', '=', 'sm_student.student_id')
        ->join('smisinterns.um_employees', 'bps_supervisor_student_ids.supervisor_id', '=', 'um_employees.id')
        ->join('smisinterns.sm_student_programme_curriculum', 'sm_student_programme_curriculum.student_id', '=', 'bps_supervisor_student_ids.student_id')
        ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')
        ->whereIn('bps_supervisor_student_ids.id', function ($query) {
            $query->select(DB::raw('MIN(bps_supervisor_student_ids.id)'))
                ->from('smisinterns.bps_supervisor_student_ids')
                ->groupBy('supervisor_id'); 
        })
       
      ->pluck('supervisor_id');

      $remainingSupervisors = SmSupervisors::whereNotIn('id', $NotAssignedSupervisors)
      ->orderBy('id', 'desc')
      ->get();
      if($remainingSupervisors->count() > 0)
      {
        $data['remainingSupervisors'] = $remainingSupervisors->count();
        $data['unassignedSupervisorData'] = $remainingSupervisors;
      }
      else
      {
        $data['remainingSupervisors'] = "0";
        $data['unassignedSupervisorData'] = "";
      }
      }


      catch(\Exception $e)
      {

        //echo $e;

  
      }
      
  
    return view('dashboard.index', $data);
    }
   



}
