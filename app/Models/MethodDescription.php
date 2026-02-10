<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MethodDescription extends Model
{
    protected $fillable = [
        'method_type',
        'method_name',
        'description',
    ];
}
