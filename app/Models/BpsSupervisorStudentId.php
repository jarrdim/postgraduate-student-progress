<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BpsSupervisorStudentId extends Model
{
    protected $table = "smisinterns.bps_supervisor_student_ids";
    protected $fillable = ['student_id', 'supervisor_id', 'status', 'created_at', 'updated_at', 'level_id'];
    use HasFactory;
}
