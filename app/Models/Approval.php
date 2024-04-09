<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = "smisinterns.approvals";
    public $timestamps = false;
    use HasFactory;
}
