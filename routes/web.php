<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ApprovedController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\HodController;
use App\Http\Controllers\DeanController;
use App\Http\Controllers\graduateSectorController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginSupervisorController;
use App\Http\Controllers\LoginHodController;
use App\Http\Controllers\LoginDeanController;
use App\Http\Controllers\LoginGraduateController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\LogoutController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard.index');
// });


Route::get("/",[CountController::class, 'dashboard']);
Route::get("/dashboard",[CountController::class, 'dashboard']);


//UNNECE
Route::get("/login",[LoginController::class, 'index']);
Route::post("/login",[LoginController::class, 'index']);

Route::get("/supervisorlogin",[LoginSupervisorController::class, 'index']);
Route::post("/supervisorlogin",[LoginSupervisorController::class, 'index']);

Route::get("/hodlogin",[LoginHodController::class, 'index']);
Route::post("/hodlogin",[LoginHodController::class, 'index']);

Route::get("/deanlogin",[LoginDeanController::class, 'index']);
Route::post("/deanlogin",[LoginDeanController::class, 'index']);

Route::get("/graduatelogin",[LoginGraduateController::class, 'index']);
Route::post("/graduatelogin",[LoginGraduateController::class, 'index']);

Route::get("/adminlogin",[LoginAdminController::class, 'index']);
Route::post("/adminlogin",[LoginAdminController::class, 'index']);

/// END





Route::get('logout',[LogoutController::class, 'index']);



Route::get('/email',[MailController::class, 'sendMail']);

Route::get('/dashboard/students',[DashboardController::class, 'index']);

Route::get('/search',[SearchController::class, 'action'])->name('search');


//check assigned page
Route::get("dashboard/viewassigned/{id}",[DashboardController::class, 'viewAssigned']);
Route::get("/delete",[DashboardController::class, 'deleteAssigned'])->name('delete');


//dashboard/students/operation/
Route::get('/dashboard/students/operation/{id}',[DashboardController::class, 'viewAction']);


//REPORT PROGRESS
Route::get('dashboard/report',[ReportController::class, 'index']);
Route::get('dashboard/progress',[ReportController::class, 'getProgressData'])->name('getProgressReport');


Route::get('/dashboard/assignstudents/operation',[DashboardController::class, 'addAction']);
Route::post('/dashboard/assignstudents/operation',[DashboardController::class, 'addAction']);

//
Route::get('dashboard/assignstudents/SelectedSupervisorsList',[DashboardController::class, 'SelectedSupervisorsList'])->name("SelectedSupervisorsList");


//APPROVED
Route::get('/dashboard/assignedSupervisors',[SupervisorController::class, 'listAssigned']);


//STUDENT

Route::get('/student/upload', [StudentController::class, 'index']);
Route::get('/student/status', [StudentController::class, 'status'])->name('status');


//Route::get('upload',[UploadController::class, 'index']);
Route::post('/student/upload',[StudentController::class, 'upload'])->name('upload');
Route::get('/student/submit/{file_id}', [StudentController::class, 'submit'])->name('submit');
Route::get('/student/change/{file_id}/{status}', [StudentController::class, 'changeFile'])->name('submit');


//supervisor section
Route::get('/supervisors/section', [SupervisorController::class, 'index']);
Route::get('supervisor/approve',[SupervisorController::class, 'approveAction'])->name("approve");

Route::get('supervisor/reject',[SupervisorController::class, 'rejectAction'])->name('reject');
Route::get('/download',[SupervisorController::class, 'downloadDocument'])->name('download');

//HOD
Route::get('/hod/section', [HodController::class, 'index']);
Route::get('/hod/reject',[HodController::class, 'rejectAction'])->name('hod_reject');
Route::get('/hod/approve',[HodController::class, 'approveAction'])->name("hod_approve");
Route::get('/hod/download',[HodController::class, 'downloadDocument'])->name('hod_download');
//DEAN
Route::get('/dean/section', [DeanController::class, 'index']);
Route::get('/dean/reject',[DeanController::class, 'rejectAction'])->name('dean_reject');
Route::get('/dean/approve',[DeanController::class, 'approveAction'])->name("dean_approve");
Route::get('/dean/download',[DeanController::class, 'downloadDocument'])->name('dean_download');

//GRADUATE SECTOR
Route::get('/graduate/section', [graduateSectorController::class, 'index']);
Route::get('/graduate/reject',[graduateSectorController::class, 'rejectAction'])->name('graduate_reject');
Route::get('/graduate/approve',[graduateSectorController::class, 'approveAction'])->name("graduate_approve");
Route::get('/graduate/download',[graduateSectorController::class, 'downloadDocument'])->name('graduate_download');
