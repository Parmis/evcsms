<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_company_id',
        'name',
    ];

    // public function station(){
    //     return $this->belongsTo('App\Models\Station','id');
    // }

}
