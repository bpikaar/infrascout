<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'name',
    ];

    /**
     * Get the reports associated with the project.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

}
