<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ref_user_id',
        'department_name',
    ];
    function ref_user(){
        return $this->hasOne(User::class,"id","ref_user_id"); //Eloquent
    }
}
