<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalHistory extends Model
{
    protected $table = "smisinterns.approvals_history";
    public $timestamps = false;
    use HasFactory;
}
