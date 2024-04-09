<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\BpsSupervisorStudentId;
use App\Models\ApprovalHistory;
use App\Models\Approval;

class HodController extends Controller
{
    //
    public function index(Request $request)
    {

       /***
        * APPROVED  select student based on dept_code
        */

        /**
         * 
         * dept_code = A55 , I18
         * 
         */
        $level_id = 2;
     
    
        $result = Upload::select('bps_document_uploads.*','sm_student.other_names', 'sm_student.student_number', 'approvals.status_id')

        ->join('smisinterns.approvals', 'approvals.file_id', '=', 'bps_document_uploads.file_id')
        ->join('smisinterns.sm_student', 'bps_document_uploads.student_id', '=', 'sm_student.student_id') 
        ->where('approvals.level_id', $level_id)
        ->orderBy('approvals.id', 'desc')
        ->get();



        if($result->count() > 0)
        {
          $data['approved'] = $result->count();
          $data['rows'] = $result;
        }
        else{
          $data['rows'] = [];
          $data['approved'] = "0";
        }

        

        /**
         * 
         * Pending approvals by supervisors
         */
        $status_id = 2;
        $level_id = 1;
         $pendingApproval = Approval::select('approvals.*',
          'bps_document_uploads.student_id',
           'sm_student.other_names',
           'sm_student.student_number',
           'sm_admitted_student.primary_email',
           'sm_admitted_student.primary_phone_no')
         ->join('smisinterns.bps_document_uploads', 'bps_document_uploads.file_id', '=' , 'approvals.file_id')
         ->join('smisinterns.sm_student', 'bps_document_uploads.student_id', '=', 'sm_student.student_id') 

         ->join('smisinterns.sm_student_programme_curriculum', 'sm_student_programme_curriculum.student_id', '=', 'bps_document_uploads.student_id')
         ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')
        
         ->where('approvals.status_id', $status_id)
         ->where('approvals.level_id', $level_id)
         ->get();
        
        if($pendingApproval->count() > 0)
        {
          $data['pendingApproval'] = $pendingApproval->count();
           $data['pendings'] = $pendingApproval;
        }
        else{
          $data['pendings'] = "";
          $data['pendingApproval'] = "0";
        }

        /*****
         * 
         * REJECTED DOCUMENTS
         */
        $status_id = 3;
        $level_id = 1;
         $rejectedDocuments = ApprovalHistory::select('approvals_history.*',
         'bps_document_uploads.student_id',
         'sm_student.other_names',
         'sm_student.student_number',
         'sm_admitted_student.primary_email',
         'sm_admitted_student.primary_phone_no'

         )
         ->join('smisinterns.bps_document_uploads', 'bps_document_uploads.file_id', '=' , 'approvals_history.file_id')
         ->join('smisinterns.sm_student', 'bps_document_uploads.student_id', '=', 'sm_student.student_id') 

        ->join('smisinterns.sm_student_programme_curriculum', 'sm_student_programme_curriculum.student_id', '=', 'bps_document_uploads.student_id')
        ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')
        
         ->where('approvals_history.status_id', $status_id)
         ->where('approvals_history.level_id', $level_id)
         ->get();

        if($rejectedDocuments->count() > 0)
        {
          $data['rejectedCount'] = $rejectedDocuments->count();
          $data['rejectedDocuments'] = $rejectedDocuments;
        }
        else{
          $data['rejectedDocuments'] = "";
          $data['rejectedCount'] = "0";
        }
    

        return view('hod.index', $data);
    }


    public function rejectAction(Request $req)
    {

        if($req->ajax())
        {

          $hodID = "775";

          $file_id = $req->get('file_id') ?? "";
          $date = date("Y-m-d H:i:s");
          $remarks = trim($req->get('remarks')) ?? "";
          

          if($remarks == "")
          {
            $data['errorMSG'] = "Remarks field is required !";
            echo json_encode($data);die;
          }
                   
          //STSRT
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
                  $newHistory->acted_on_by = $hodID;
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

    public function approveAction(Request $request)
    {
      $data = [];
      $hodID = "775";

      if($request->ajax())
      {
        $file_id = $request->get('file_id') ?? "";
       

        DB::beginTransaction();
        try {
            $date =  date("Y-m-d H:s:i");// Replace with the new date
           
            
            $existingApproval = Approval::where('file_id', $file_id)->first();
            if ($existingApproval) {
                $existingApproval->level_id = 3;
                $existingApproval->status_id = 2;
                $existingApproval->acted_on_by = $hodID;
                $existingApproval->date_acted_upon = $date;
                $existingApproval->save();
            }
    
            // Retrieve existing record from the ApprovalHistory table
            $existingHistory = ApprovalHistory::where('file_id', $file_id)->first();

            if ($existingHistory) {
                // Clone the existing history record and update its attributes
                $newHistory = $existingHistory->replicate(); // Clone the existing record
                //$newHistory->file_id = $randomId;
                $newHistory->level_id = 4;
                $newHistory->date_acted_upon = $date;
                $newHistory->acted_on_by = $hodID;
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
