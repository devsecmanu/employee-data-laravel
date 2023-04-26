<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'email',
        'phone',
        'gender',
    ];
    public $primaryKey = 'employee_id';
}