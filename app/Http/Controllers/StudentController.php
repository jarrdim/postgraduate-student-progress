<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\upload;
use App\Models\Approval;
use App\Models\ApprovalHistory;
use App\Models\BpsSupervisorStudentId;
use App\Models\ApprovalStatus;

class StudentController extends Controller
{
    //
     //
     public function index(Request $request)
     {
 
      //maina = 399
      //mshidi = 819
      //hekima = 1217
      //david =session('student_id')
       $data = [];
       $student_id =session('student_id') ??  "";
   
  
     
         //$res = DB::select("select status_id from smisinterns.bps_document_uploads where student_id = :student_id limit 1",['student_id' => $student_id]);
        $res = upload::select('bps_document_uploads.*', 'approvals_history.status_id')
         ->join('smisinterns.approvals_history','bps_document_uploads.file_id', '=' , 'approvals_history.file_id' )
         ->where('student_id', $student_id)
         ->get();
       

        if($res)
        {
         
          $doc_status = "";
          $data['status'] = '';
          $data['file_id'] = '';
          foreach($res as $status)
            {
              $data['status'] = $status->status_id;
              $data['file_id']= $status->file_id;

              $filename = $status->file;
             $firstUnderscorePos = strpos($filename, '_');

             
            if ($firstUnderscorePos !== false) {
             
                // Extract the substring before the first underscore
                $substringBeforeUnderscore = substr($filename, 0, $firstUnderscorePos);

                // Replace underscores with spaces in the extracted substring
                $replacedSubstring = str_replace('_', ' ', $substringBeforeUnderscore);

                // Create the new filename by combining the replaced substring and the rest of the original filename
                $newFilename = str_replace($replacedSubstring."_", " ", $filename) ;//$replacedSubstring . substr($filename, $firstUnderscorePos);

                $data['file_name'] = $newFilename;
            } else {
                // No underscore found, so keep the original filename
                $data['file_name'] = $filename;
            }

 
           }
          
           
           try{
            $statusName =  ApprovalStatus::where('id', $status->status_id)->value('name');
            if($status)
            {
                 $data['statusName'] = strtoupper($statusName);
            }}
            catch(\Exception $e)
            {
              $data['statusName'] = "";
            }

     
          
            
        }
      
      
        return view('student.index',$data);
     }
 
     public function upload(Request $request)
     {
            // Validation
            $request->validate([
                 'file' => 'required|mimes:pdf|max:5120'
               ]);

               $studentId=499 ?? '';
               $result2 =BpsSupervisorStudentId::select('bps_supervisor_student_ids.*', 'um_employees.other_names','um_employees.payroll_number', 'um_employees.email' )
               ->JOIN('smisinterns.um_employees' , 'bps_supervisor_student_ids.supervisor_id', '=' , 'um_employees.id')
             
               ->where('student_id', $studentId)
                ->orderBy('id', 'desc')
                ->get();
     
               if($request->file('file') && $result2->count() > 0) {
                     $file = $request->file('file');
                     $filename = time().'_'.$file->getClientOriginalName();
                     $location = 'uploads';
                     $date = date("Y-m-d H:s:i");
                     $file->move($location,$filename);
                     $randomId = random_int(10000, 99999); 
                     
                     /**CHECK IF RECORD EXIST */
                     //$result = Upload::where('student_id',  $studentId)->get();
                     $result = Upload::select('bps_document_uploads.*', 'approvals_history.status_id')
                     ->join('smisinterns.approvals_history','approvals_history.file_id', '=', 'bps_document_uploads.file_id' )
                     ->where('student_id',   $studentId)
                     ->get();
                    // $status = ApprovalHistory::where('file_id',  $studentId)->value('status_id');
                   
                     if($result->count() > 0)
                     {
                    

                      //  foreach($result as $arr)
                      //  {

                     
                      //    $existFil = "uploads/".$arr->file;
                      //    if(file_exists($existFil))
                      //    {
                      //      unlink($existFil);
                      //    }
                      //  }
                      
                      //  Upload::first('student_id',  $studentId)->delete();
 
                      
                     }
                     if($result->count() > 0)
                     {
                       
                      DB::beginTransaction();
                      try {
                       

                        //
                        
                        
                       foreach($result as $arr)
                       {
                        $file_id = $arr->file_id;
                        $existingUpload = Upload::where('file_id', $file_id)->first();
                  
                        if ($existingUpload) {
                            $existingUpload->updated_at = $date; // Update the updated_at field
                            $existingUpload->file = $filename; // Update the updated_at field
      
                            $existingUpload->save();
                           
                        }

              
    
                    
                       }

                       $Approval = new Approval();
                       $Approval->file_id = $file_id;
                       $Approval->level_id = 1;
                       $Approval->status_id = 1;
                       $Approval->date_acted_upon = $date;
                       $Approval->acted_on_by =  $studentId;
                       $Approval->save();

                       

                       $history = new ApprovalHistory();
                       $history->file_id = $file_id;
                       $history->level_id = 1;
                       $history->date_acted_upon = $date;
                       $history->acted_on_by =  $studentId;
                       $history->status_id = 1;
                       $history->save();

                   
                        
                        //
                     
                          // $upload = new Upload();
                          // $upload->file_id = $randomId;
                          // $upload->file = "filename";
                          // $upload->student_id = $studentId;
                          // $upload->created_at = $date;
                          // $upload->updated_at = $date;
                          // $upload->save();

                          // $Approval = new Approval();
                          // $Approval->file_id = $randomId;
                          // $Approval->level_id = 1;
                          // $Approval->status_id = 1;
                          // $Approval->date_acted_upon = $date;
                          // $Approval->acted_on_by =  $studentId;
                          // $Approval->save();


                          // $history = new ApprovalHistory();
                          // $history->file_id = $randomId;
                          // $history->level_id = 1;
                          // $history->date_acted_upon = $date;
                          // $history->acted_on_by =  $studentId;
                          // $history->status_id = 1;
                          // $history->save();



                          Session::flash('message','Uploaded Successfully.');
                          Session::flash('alert-class', 'alert-success');
                    
                          DB::commit();

                        } catch (\Exception $e) {
                          DB::rollback(); // Rollback the transaction if an error occurs
                          throw $e; // You can handle the exception as needed
                          Session::flash('message','File not uploaded.');
                          Session::flash('alert-class', 'alert-successr');
                      }
                     }
                     else{

                      $upload = new Upload();
                      $upload->file_id = $randomId;
                      $upload->file = $filename;
                      $upload->student_id = $studentId;
                      $upload->created_at = $date;
                      $upload->updated_at = $date;
                      $upload->save();

                      $Approval = new Approval();
                      $Approval->file_id = $randomId;
                      $Approval->level_id = 1;
                      $Approval->status_id = 1;
                      $Approval->date_acted_upon = $date;
                      $Approval->acted_on_by =  $studentId;
                      $Approval->save();


                      $history = new ApprovalHistory();
                      $history->file_id = $randomId;
                      $history->level_id = 1;
                      $history->date_acted_upon = $date;
                      $history->acted_on_by =  $studentId;
                      $history->status_id = 1;
                      $history->save();
                     }
   
               }else{
                     Session::flash('message','File not uploaded.');
                     Session::flash('alert-class', 'alert-danger');
               }
               return redirect('student/upload');
          }


          public function submit(Request $request, $file_id = "")
          {
              DB::beginTransaction();
              try {
                  $date =  date("Y-m-d H:s:i");// Replace with the new date
                  
                  $existingUpload = Upload::where('file_id', $file_id)->first();
                  
                  if ($existingUpload) {
                      $existingUpload->updated_at = $date; // Update the updated_at field

                      $existingUpload->save();
                  }
          
                  $existingApproval = Approval::where('file_id', $file_id)->first();
                  if ($existingApproval) {
                      $existingApproval->level_id = 1;
                      $existingApproval->status_id = 2;
                      $existingApproval->date_acted_upon = $date;
                      $existingApproval->save();
                  }
          
                  // Retrieve existing record from the ApprovalHistory table
                  $existingHistory = ApprovalHistory::where('file_id', $file_id)->first();

                  if ($existingHistory) {

                      $newHistory = $existingHistory->replicate(); 
                      $newHistory->level_id = 2;
                      $newHistory->date_acted_upon = $date;
                      $newHistory->status_id = 2;
                      
                     
                      $newHistory->save();
                  }
          
                  DB::commit();
                  Session::flash('message', 'Submitted Successfully.');
                  Session::flash('alert-class', 'alert-success');
              } catch (\Exception $e) {
                  DB::rollback();
                 
                  Session::flash('message', 'An error occurred.');
                  Session::flash('alert-class', 'alert-danger');
              }
          
              return redirect('student/upload');
          }


          public function changeFile(Request $request, $file_id, $status)
          {

            
            //echo $status;die;
            DB::beginTransaction();
            try {

                
              if($status)
                {
            
                $date =  date("Y-m-d H:s:i"); // Replace with the new date
                
                $existingUpload = Upload::where('file_id', $file_id)->first();
                
                if ($existingUpload) {
                    //$existingUpload->updated_at = $date; // Update the updated_at field
                    $existingUpload->delete();
                }
        
                $existingApproval = Approval::where('file_id', $file_id)->first();
                if ($existingApproval) {
                    //$existingApproval->date_acted_upon = $date;
                    $existingApproval->delete();
                }
        
                // Retrieve existing record from the ApprovalHistory table
                $existingHistory = ApprovalHistory::where('file_id', $file_id)->first();

                if ($existingHistory) {
                    // Clone the existing history record and update its attributes
                   // $newHistory = $existingHistory->replicate(); // Clone the existing record
                   // $existingHistory->date_acted_upon = $date;
                    //$existingHistory->status_id = 1;
                    
                    // Save the new history record
                    $existingHistory->delete();
                }
              }
                DB::commit();
                Session::flash('message', 'Upload new document.');
                Session::flash('alert-class', 'alert-success');
              
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
                Session::flash('message', 'An error occurred.');
                Session::flash('alert-class', 'alert-danger');
            }
            
            return redirect('student/upload');
          }



          public function status(Request $request)
          {
            $data =[];

            if($request->ajax())
            {
   
              //$request->get('student_id')
              
              try{
                $student_id =session('student_id') ??  "";
     
                //$res = DB::select("select status_id from smisinterns.bps_document_uploads where student_id = :student_id limit 1",['student_id' => $student_id]);
               $res = upload::select('bps_document_uploads.*', 'approvals_history.level_id', 'approvals_history.status_id')
                ->join('smisinterns.approvals_history','bps_document_uploads.file_id', '=' , 'approvals_history.file_id' )
                ->where('student_id', $student_id)
                ->get();
                if($res)
                {
                 
                  $doc_status = "";
                  $data['status'] = '';
                  $data['file_id'] = '';
                  foreach($res as $status)
                    {
                      $data['level_id'] = $status->level_id;
                      $data['status'] = $status->status_id;
                     $data['file_id'] = $status->file_id;
                     
                   }
                  }

                
                
                $data['success'] = "success";
              }
              catch(\Exception $e)
              {
                $data['error'] = 'Error occured';
              }
            }

            echo json_encode($data);
       
           
          }
          
}
