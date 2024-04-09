<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Mail\EmailNotification;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
   
    public function sendMail()
    {
       try {
            $mailData = [
                'title' => "Notification",
                'body' => 'Your project/thesis was approved',
            ];
    
            Mail::to('mutisojacob86@gmail.com')->send(new EmailNotification($mailData));
    
            Session::flash("message", "Notification sent successfully");
            Session::flash('alert-class', 'alert-success');
        } catch (\Exception $e) {
            // Handle the exception here, you can log the error or display an error message to the user.
            // For example:
            Session::flash("message", "Failed to send notification. Please try again later.");
            Session::flash('alert-class', 'alert-danger');
            // Log the error to the error log
            \Log::error("Failed to send notification: " . $e->getMessage());
        }

        //return redirect('/dashboard/students');
       return redirect('/graduate/section');
        //return redirect('/email');
    }

   
}
