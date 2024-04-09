<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\BpsSupervisorStudentId;
use App\Models\ApprovalHistory;
use App\Models\Approval;
use App\Models\SmStudentProgrammeCurriculum;

use App\Mail\EmailNotification;
use Illuminate\Support\Facades\Mail;



class GraduateSectorController extends Controller
{
    //
    public function index(Request $request)
    {

      /***
       * 
       * COMPLETED STUDENTS
       */

       $level_id = 4;
       $status_id = 4;
    
   
       $completed = Upload::select('bps_document_uploads.*',
       'sm_student.other_names', 
       'sm_student.student_number',
        'approvals.status_id',
       'approvals.level_id',
       'sm_admitted_student.primary_email',
       'sm_admitted_student.primary_phone_no')

       ->join('smisinterns.approvals', 'approvals.file_id', '=', 'bps_document_uploads.file_id')
       ->join('smisinterns.sm_student', 'bps_document_uploads.student_id', '=', 'sm_student.student_id') 

       ->join('smisinterns.sm_student_programme_curriculum', 'sm_student_programme_curriculum.student_id', '=', 'bps_document_uploads.student_id')
       ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')

       ->where('approvals.level_id', $level_id)
       ->where('approvals.status_id', $status_id)
       ->orderBy('approvals.id', 'desc')
       ->get();
        //echo "<pre>";
       // print($completed);

        if($completed->count() > 0)
        {
            $data['completedCount'] = $completed->count();
          $data['completed'] = $completed;
        }
        else{
            $data['completedCount'] = "0";
          $data['completed'] = [];
        }

       
     /**
       * 
       * APPROVED DOCUMENTS BY DEAN
       */
      $status_id = 2;
        $level_id = 4;
        
     
    
        $result = Upload::select('bps_document_uploads.*','sm_student.other_names', 'sm_student.student_number', 'approvals.status_id',
        'approvals.level_id')

        ->join('smisinterns.approvals', 'approvals.file_id', '=', 'bps_document_uploads.file_id')
        ->join('smisinterns.sm_student', 'bps_document_uploads.student_id', '=', 'sm_student.student_id') 
        ->where('approvals.level_id', $level_id)
        ->where('approvals.status_id', $status_id)
        ->orderBy('approvals.id', 'desc')
        ->get();
     

        if($result->count() > 0)
        {
            $data['approved'] = $result->count();
          $data['rows'] = $result;
        }
        else{
            $data['approved'] = "0";
          $data['rows'] = [];
        }

        
          /**
         * 
         * Pending approvals by supervisors
         */
        // $status_id = 2;
        // $level_id = 3;
        $status_id = 2;
        $level_id = 3;
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
          $data['pendingApproval'] = "0";
          $data['pendings'] = "";
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
          $data['rejectedCount'] = "0";
          $data['rejectedDocuments'] = "";
        }


            /**
             * 
             * REMAINING STUDENTS (YET TO UPLOAD THEIR DOUMENTS/PROJECT)
             * 
             */
            $studentsSubmittedDocument = DB::table('smisinterns.approvals')
            ->select(
            'approvals.id', 
            'approvals.file_id', 
            'approvals.level_id', 
            'approvals.remarks', 
            'approvals.date_acted_upon',
            'approvals.status_id',
            'approvals.acted_on_by',

            'bps_document_uploads.student_id'        
            )
            ->join('smisinterns.bps_document_uploads','bps_document_uploads.file_id', '=' , 'approvals.file_id')
            ->pluck('student_id');

            $remainingStudentsData =  SmStudentProgrammeCurriculum::select(
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

                'sm_admitted_student.primary_email as student_email',
                'sm_admitted_student.primary_phone_no as student_phone'
            )
            ->join('smisinterns.sm_student_category', 'sm_student_programme_curriculum.student_category_id', '=', 'sm_student_category.std_category_id')
            ->join('smisinterns.sm_student', 'sm_student_programme_curriculum.student_id', '=', 'sm_student.student_id')
            ->join('smisinterns.org_programme_curriculum', 'sm_student_programme_curriculum.prog_curriculum_id', '=', 'org_programme_curriculum.prog_curriculum_id')
            ->join('smisinterns.org_programmes', 'org_programme_curriculum.prog_id', '=', 'org_programmes.prog_id')
            ->join('smisinterns.org_prog_type', 'org_programmes.prog_type_id', '=', 'org_prog_type.prog_type_id')

            ->join('smisinterns.sm_admitted_student', 'sm_admitted_student.adm_refno', '=', 'sm_student_programme_curriculum.adm_refno')
            ->whereNotIn('sm_student.student_id', $studentsSubmittedDocument)
            ->get();

            if($remainingStudentsData->count() > 0)
            {
                 $data['remainingCount'] = $remainingStudentsData->count();
                 $data['remaingStudents'] = $remainingStudentsData;
                //echo "<pre>";
                //print_r($remainingStudentsData);
            }
            else{
                $data['remainingCount'] = "0";
                $data['remaingStudents'] = "";
            }
            


        return view('graduate.index', $data);
    }



    public function rejectAction(Request $req)
    {

      $graduateID = "3321";
        if($req->ajax())
        {
          $file_id = $req->get('file_id') ?? "";
           
          $date = date("Y-m-d H:i:s");
                   
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
                 /* $existingApproval->level_id = 1;
                  $existingApproval->status_id = 3;
                  $existingApproval->acted_on_by = 4;
                  $existingApproval->date_acted_upon = $date;*/
                  $existingApproval->delete();
              }
      
              // Retrieve existing record from the ApprovalHistory table
              $existingHistory = ApprovalHistory::where('file_id', $file_id)->first();

              if ($existingHistory) {
                  // Clone the existing history record and update its attributes
                  $newHistory = $existingHistory->replicate(); // Clone the existing record
                  //$newHistory->file_id = $randomId;
                  $newHistory->level_id = 1;
                  $newHistory->date_acted_upon = $date;
                  $newHistory->acted_on_by = $graduateID ;
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
      $graduateID = "3321";
      $data = [];
      if($request->ajax())
      {
        $file_id = $request->get('file_id') ?? "";
       

        DB::beginTransaction();
        try {
            $date =  date("Y-m-d H:s:i");// Replace with the new date
           
            
            $existingApproval = Approval::where('file_id', $file_id)->first();
            if ($existingApproval) {
                $existingApproval->level_id = 4;
                $existingApproval->status_id = 4;
                $existingApproval->acted_on_by = $graduateID;
                $existingApproval->date_acted_upon = $date;
                $existingApproval->save();
            }
    
            // Retrieve existing record from the ApprovalHistory table
            $existingHistory = ApprovalHistory::where('file_id', $file_id)->first();

            if ($existingHistory) {
                // Clone the existing history record and update its attributes
                $newHistory = $existingHistory->replicate(); // Clone the existing record
                //$newHistory->file_id = $randomId;
                $newHistory->level_id = 6;
                $newHistory->date_acted_upon = $date;
                $newHistory->acted_on_by = $graduateID;
                $newHistory->status_id = 4;
                
                // Save the new history record
                $newHistory->save();
            }

                
                    $mailData = [
                        'title' => "Notification",
                        'body' => 'Your project was approved',
                    ];
            
                   // Mail::to('mutisojacob86@gmail.com')->send(new EmailNotification($mailData));
            
             

            
            DB::commit();
        
            $data['success'] = 'Approved Successfully.';
        
        } catch (\Exception $e) {
            DB::rollback();
            
            //throw $e;
           // Session::flash('message', 'An error occurred.');
            //Session::flash('alert-class', 'alert-danger');
            $data['error']='An error occurred ';
           // Session::flash('alert-class', 'alert-success');
           
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
