<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Upload;
use Illuminate\Support\Facades\Session;
use App\Models\BpsSupervisorStudentId;
use App\Models\ApprovalHistory;
use App\Models\Approval;


class SupervisorController extends Controller
{
    public function index(Request $request)
    {

        $supervisor_id = 1;
        $level_id = 1;
     
    
        $result = Upload::select('bps_document_uploads.*','sm_student.other_names', 'sm_student.student_number', 'approvals.status_id')

        ->join('smisinterns.approvals', 'approvals.file_id', '=', 'bps_document_uploads.file_id')

        //->join('smisinterns.approvals_history', 'approvals_history.level_id', '=', 'approvals.level_id')

        ->join('smisinterns.sm_student', 'bps_document_uploads.student_id', '=', 'sm_student.student_id')

        ->join('smisinterns.bps_supervisor_student_ids', 'bps_supervisor_student_ids.student_id', '=', 'bps_document_uploads.student_id')

        ->where('bps_supervisor_student_ids.supervisor_id', $supervisor_id)
        ->where('approvals.level_id', $level_id)
        ->orderBy('approvals.id', 'desc')
        ->get();
    
    


       //echo "<pre>";

        //print_r($result);
    
    


        if($result)
        {
          $data['rows'] = $result;
        }
        else{
          $data['rows'] = [];
        }

       // echo "<pre>";
       // print_r($data);
        return view('supervisor.supervisor', $data);
    }

    //ASSIGNed

    public function listAssigned(Request $request)
    {
      //maina = 399
      //mshidi = 819
      //hekima = 1219
      //david = 499

      $studentId= 499;
      //$result = DB::select("select * from uploads where receiver_id = :receiver_id order by id desc" ,['receiver_id'=> $receiverId]);
      $result =BpsSupervisorStudentId::select('bps_supervisor_student_ids.*', 'um_employees.other_names','um_employees.phone_number', 'um_employees.email' )
      ->JOIN('smisinterns.um_employees' , 'bps_supervisor_student_ids.supervisor_id', '=' , 'um_employees.id')
    
      ->where('student_id', $studentId)
        ->orderBy('id', 'desc')
        ->get();


      if($result)
      {
        $data['rows'] = $result;
      }
      else{
        $data['rows'] = [];
      }


     

      return view("dashboard.list.supervisors", $data);
    }
    


    public function approveAction(Request $request)
    {
      $data = [];
      $supervisorID = "3338";
      if($request->ajax())
      {
        $file_id = $request->get('file_id') ?? "";
       

        DB::beginTransaction();
        try {
            $date =  date("Y-m-d H:s:i");// Replace with the new date
      
            
            $existingApproval = Approval::where('file_id', $file_id)->first();
            if ($existingApproval) {
                $existingApproval->level_id = 2;
                $existingApproval->status_id = 2;
                $existingApproval->acted_on_by = $supervisorID;
                $existingApproval->date_acted_upon = $date;
                $existingApproval->save();
            }
    
            // Retrieve existing record from the ApprovalHistory table
            $existingHistory = ApprovalHistory::where('file_id', $file_id)->first();

            if ($existingHistory) {
                // Clone the existing history record and update its attributes
                $newHistory = $existingHistory->replicate(); // Clone the existing record
                //$newHistory->file_id = $randomId;
                $newHistory->level_id = 3;
                $newHistory->date_acted_upon = $date;
                $newHistory->acted_on_by = $supervisorID;
                $newHistory->status_id = 2;
                
                // Save the new history record
                $newHistory->save();
            }
    
            DB::commit();
           // Session::flash('message', 'Submitted Successfully.');
           // Session::flash('alert-class', 'alert-success');
            $data['success'] = 'Approved Successfully.';
        } catch (\Exception $e) {
            DB::rollback();
            
            //throw $e;
           // Session::flash('message', 'An error occurred.');
            //Session::flash('alert-class', 'alert-danger');
            $data['error']='An error occurred ' .$e;
           
        }

       
      }
     


      echo json_encode($data);


    }
    public function rejectAction(Request $req)
    {

      
        if($req->ajax())
        {
          $file_id = $req->get('file_id') ?? "";
          $remarks = trim($req->get('remarks')) ?? "";
          $date = date("Y-m-d H:i:s");
                   
          //STSRT
          if($remarks == "")
          {
            $data['errorMSG'] = "Remarks field is required !";
            echo json_encode($data);die;
          }
       


          DB::beginTransaction();
          try {
              $date =  date("Y-m-d H:s:i");// Replace with the new date
              //echo json_encode($file_id);die;
              $existingUpload = Upload::where('file_id', $file_id)->first();
              //echo json_encode($file_id);die;
              if ($existingUpload) {
                  $existingUpload->updated_at = $date; // Update the updated_at field
                  $existingUpload->save();
              }
              
              $existingApproval = Approval::where('file_id', $file_id)->first();
              if ($existingApproval) {
                  /*$existingApproval->level_id = 1;
                  $existingApproval->status_id = 3;
                  $existingApproval->acted_on_by = 2;
                  $existingApproval->date_acted_upon = $date;*/
                  $existingApproval->delete();
              }
      
              // Retrieve existing record from the ApprovalHistory table
              $existingHistory = ApprovalHistory::where('file_id', $file_id)->first();

              if ($existingHistory) {
                  // Clone the existing history record and update its attributes
                  $newHistory = $existingHistory->replicate(); // Clone the existing record
                  //$newHistory->file_id = $randomId;
                  $newHistory->remarks = $remarks;
                  $newHistory->level_id = 1;
                  $newHistory->date_acted_upon = $date;
                  // $newHistory->acted_on_by = $studentId;
                  $newHistory->status_id = 3;
                  
                  // Save the new history record
                  $newHistory->save();
              }
      
              DB::commit();
             // Session::flash('message', 'Submitted Successfully.');
             // Session::flash('alert-class', 'alert-success');
              $data['success'] = 'Submitted Successfully.';
          } catch (\Exception $e) {
              DB::rollback();
              
              //throw $e;
             // Session::flash('message', 'An error occurred.');
              //Session::flash('alert-class', 'alert-danger');
              $data['error']='An error occurred.';
             
          }



          echo json_encode($data);die;
        
        
             
            
          
        
       
        }
    }

    public function downloadDocument(Request $req)
    {

     if($req->ajax())
     {
       $filename  = $req->get('filename');
       $data['yes']= "success";
       $data['filename'] = $filename;


       $filePath = public_path('uploads/' . $filename);

       // Check if the file exists
       if (file_exists($filePath)) {
           // Generate a temporary URL for the download
           $temporaryUrl = 'uploads/' . $filename;

           // Return the temporary URL to the client-side
           return response()->json(['success' => true, 'url' => $temporaryUrl]);
       } else {
           // File not found, return an error to the client-side
           return response()->json(['success' => false, 'message' => 'File not found.']);
       }




     }
     echo json_encode($data);
    }
}
