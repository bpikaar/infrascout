<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'pipe_type',
        'material',
        'diameter',
    ];

    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }
}
