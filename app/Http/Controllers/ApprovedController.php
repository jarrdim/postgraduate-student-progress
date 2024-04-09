<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApprovedController extends Controller
{
    public function index(Request $request)
    {


        return view("dashboard.approved.approvedstudents");
    }
}
