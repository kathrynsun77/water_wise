<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pipe extends Model
{
    use HasFactory;
    protected $table = "pipe";
    protected $primaryKey = "pipe_id";
    protected $guarded = ['pipe_id'];
    public $timestamps = false;
}
