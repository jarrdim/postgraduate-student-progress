<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\SmStudentProgrammeCurriculum;
use App\Models\SmSupervisors;
use App\Models\BpsSupervisorStudentId;
use App\Models\BpsSupervisorsStudentsHhistory;


class DashboardController extends Controller
{



    public function index(Request $request)
    {
        $data = [];
         return view('dashboard.students',$data);
    }
    
    public function viewAssigned(Request $request, $id='')
    {
        $data = [];
        $studentId = trim($id) ?? "";
        $data['studentId'] = $studentId;
        $result = [];
       
        $registrationNumber =SmStudentProgrammeCurriculum::where('student_id', $studentId)
        ->value('registration_number');
        $data['studentNumber'] = $registrationNumber ?? "";

        try{
    
        $result = BpsSupervisorStudentId::select('bps_supervisor_student_ids.*', 'um_employees.*', 'sm_student_programme_curriculum.registration_number', 'sm_student.other_names as student_name')

        ->join('smisinterns.sm_student','bps_supervisor_student_ids.student_id' , '=', 'sm_student.student_id')

        ->join('smisinterns.um_employees', 'bps_supervisor_student_ids.supervisor_id', '=', 'um_employees.id')
        ->join('smisinterns.sm_student_programme_curriculum', 'sm_student_programme_curriculum.student_id', '=', 'bps_supervisor_student_ids.student_id')
        ->where('bps_supervisor_student_ids.student_id', $studentId)
        ->orderBy('bps_supervisor_student_ids.id', 'desc')
        ->get();
        if(count($result) > 0)
        {
           $data['rows'] = $result;

           foreach($result as $row)
           {
            $data['studentNumber'] = $row->registration_number ?? "";
            $data['studentName'] = $row->student_name ?? "";

           }

          
        }
        else{
          $data['rows'] = [];
        }
        
       
        }
        catch(\Exception $e)
        {
          
        }

        
       
        return view('dashboard.assignedsupervisor',$data);
       
    }
 

 

 
    public function deleteAssigned(Request $request)
    {
      
      DB::beginTransaction();
      try {
        if ($request->ajax()) {
            $supervisor_id = $request->get("id");
            $remarks = trim($request->get('remarks')) ?? "";
            $date = date("Y-m-d H:i:s");
          
            if($remarks == "")
            {
              $data['errorMSG'] = "Remarks field is required !";
              echo json_encode($data);die;
            }
            
            $deletedRows = BpsSupervisorStudentId::where('supervisor_id', $supervisor_id)->delete();

            // return response()->json(['success' => true, 'message' => 'Record deleted successfully']);

               //HISTORY
                  $existingHistory = BpsSupervisorsStudentsHhistory::where('supervisor_id', $supervisor_id)->first();
                  if ($existingHistory) {
                      // Clone the existing history record and update its attributes
                      $existingHistory = $existingHistory->replicate(); // Clone the existing record
                      
                      //$existingHistory->student_id = $studentId;
                      $existingHistory->remarks = $remarks;
                      //$existingHistory->supervisor_id = $supervisorId;
                      //$existingHistory->status = "active";
                      $existingHistory->created_at = $date;
                      $existingHistory->updated_at = $date;
          
                      $existingHistory->save();


                  }



        }

      DB::commit();
      return response()->json(['success' => true, 'message' => 'Record deleted successfully']);
      } catch (\Exception $e) {
          DB::rollback();
          return response()->json(['success' => false, 'message' => 'Error deleting record']);
      }
      }

    //ASSIGNMENT FUNCTIONS
    public function viewAction(Request $request, $id="")
    {
      $data = [];
      $registrationNumber = "";

      //$studentId= $id ?? " ";
      $studentId = is_numeric($id) ? $id : null;
      $data['studentId'] = $id;

      $result = [];

      try{

              //START
        $result = SmStudentProgrammeCurriculum::select(
        'sm_student_programme_curriculum.registration_number',
        'sm_student_status.status',
        'sm_student_status.current_status',
        'org_programme_curriculum.prog_curriculum_desc',
        'sm_student.other_names',
        'sm_admitted_student.primary_email',
        'sm_admitted_student.primary_phone_no',

        'org_programmes.prog_short_name',
        'org_programmes.prog_full_name'
        )
        ->join('smisinterns.sm_student_status', 'sm_student_status.status_id', '=', 'sm_student_programme_curriculum.status_id')
        ->join('smisinterns.org_programme_curriculum', 'org_programme_curriculum.prog_curriculum_id', '=', 'sm_student_programme_curriculum.prog_curriculum_id')
        ->join('smisinterns.sm_student', 'sm_student.student_id', '=', 'sm_student_programme_curriculum.student_id')
        ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')
        ->join('smisinterns.org_programmes','org_programmes.prog_id', '=', 'org_programme_curriculum.prog_id')
        ->where('smisinterns.sm_student_programme_curriculum.student_id', '=', $studentId)
        ->get();
        //END

        if(!empty($result->count() > 0))
        {
          $data['studentProfile'] = $result;
          foreach($result as $reg)
          {
              $data['registrationNumber'] =  $reg->registration_number;
              $data['other_names'] =  $reg->other_names;
              $data['prog_short_name'] =  $reg->prog_short_name;
              $data['status'] =  $reg->status;
              $data['email'] = $reg->primary_email;

          }
        
        }
        else{
          $data['studentProfile'] = [];
          $data['registrationNumber'] = "";
         
        }

      }
      catch(\Exception $e)
      {
        //Session::flash('error', "");
          
      }


        $assignedSupervisors = BpsSupervisorStudentId::where('student_id', '=', $studentId)
        ->pluck('supervisor_id');

      $remainingEmployees = SmSupervisors::whereNotIn('id', $assignedSupervisors)
          ->orderBy('id', 'desc')
          ->get();

        
       $data['rows'] = $remainingEmployees ;


    
      return view('dashboard.assignstudents',$data);
    }

    public function addAction(Request $request, $id = "")
    {
      
      $data =[];
      $selectedData = $request->all(); 

      //echo json_encode($selectedData);die;
      
      if (isset($selectedData['supervisors'])  && isset($selectedData['studentId']) && is_numeric($selectedData['studentId'])) {
        $supervisorIds = json_decode($selectedData['supervisors']);

        
        $studentId = $selectedData['studentId'];
        $leadSupervisorId = $selectedData['leadSupervisor'];
        $date = date("Y-m-d H:i:s");
       
        if (is_array($supervisorIds) && !empty($supervisorIds)) {
          //$data['message']="";
          DB::beginTransaction();
          try{
            foreach ($supervisorIds as $supervisorId) {
                // Check if the record already exists in the database
                  $existingRecord = BpsSupervisorStudentId::where('student_id', $studentId)
                      ->where('supervisor_id', $supervisorId)
                      ->first();

                  // If the record exists, update it; otherwise, create a new record

                  if ($existingRecord) {
                      $existingRecord->update([
                          'status' => "active",
                          'updated_at' => $date
                      ]);
                      $data['message']="saved successfully";
                  } else {
                    $newRecord = BpsSupervisorStudentId::create([
                          'student_id' => $studentId,
                          'supervisor_id' => $supervisorId,
                          'status' => "active",
                          'level_id'=>'0',
                          'created_at' => $date,
                          'updated_at' => $date
                      ]);
                  
                  }
                  //SET LEAD SUPERVISOR
                  $lId = "1";
                  $leadRecordIfExist = BpsSupervisorStudentId:://where('supervisor_id',$leadSupervisorId)
                  where('student_id', $studentId)
                  ->where('level_id',$lId )
                  ->first();
                           
                  if($leadRecordIfExist)
                  {
                    $leadRecordIfExist->level_id = 0;
                    $leadRecordIfExist->created_at = $date;
                    $leadRecordIfExist->updated_at = $date;
                    $leadRecordIfExist->save();

                    $recordToUpdate1 = BpsSupervisorStudentId::where('supervisor_id', $leadSupervisorId)
                    ->where('student_id', $studentId)
                    ->first();
                      if ($recordToUpdate1) {
                        $recordToUpdate1->level_id = 1; // Set the new level_id value
                        $recordToUpdate1->created_at = $date; // Set the new level_id value
                        $recordToUpdate1->updated_at= $date; // Set the new level_id value
                        $recordToUpdate1->save();
                        }
                  }
                  else{
                    $recordToUpdate = BpsSupervisorStudentId::where('supervisor_id', $leadSupervisorId)
                    -> where('student_id', $studentId)
                    ->first();
                    
                      if ($recordToUpdate) {
                        $recordToUpdate->level_id = 1; // Set the new level_id value
                        $recordToUpdate->created_at = $date; // Set the new level_id value
                        $recordToUpdate->updated_at = $date; // Set the new level_id value
                        $recordToUpdate->save();
                    }

                  }
               
                  //END

                  $newHistory = new BpsSupervisorsStudentsHhistory;
                     
                      $newHistory->student_id = $studentId;
                      $newHistory->supervisor_id = $supervisorId;
                      $newHistory->status = "active";
                      $newHistory->created_at = $date;
                      $newHistory->updated_at = $date;
                      $newHistory->save();
            }
              DB::commit();
              $data['status'] = "yes";
              $data['message']="saved successfully";
          
            
          }
            catch(\Exception $e)   
            {
            
              
              DB::rollback();
              $data['status'] = "no";
              $data['error'] = "invalid input".$e;
            }
           
        }
        else{
          $data['status'] = "no";
          $data['error'] = "invalid input";
        }
       
    }

    echo json_encode($data);
    }
 


   

    public function SelectedSupervisorsList(Request $request)
    {
    if ($request->ajax()) {
        $selectedSupervisorsIds = $request->get("selectedSupervisors");
        $studentId = $request->get("studentID");

        try {
            $leadRecord = BpsSupervisorStudentId::
                where('student_id', $studentId)
                ->pluck('supervisor_id')
                ->toArray(); // Convert the plucked collection to an array

            if (count($leadRecord) > 0) {
                $combinedArray = array_merge($selectedSupervisorsIds, $leadRecord);

                $result = SmSupervisors::whereIn('id', $combinedArray)->get();

                return response()->json($result);
            } else {
                $result = SmSupervisors::whereIn('id', $selectedSupervisorsIds)->get();

                return response()->json($result);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}

}
