<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * @var string[]
     */
    protected $casts = [
        'date_of_work' => 'datetime', // will be cast to Carbon
    ];
}
