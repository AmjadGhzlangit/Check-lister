<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'checklist_group_id',
        'name'
    ];

    
    public function checklist_group() : BelongsTo
    {
        return $this->belongsTo(ChecklistGroup::class);
    }

    public function tasks(): HasMany
    {
       return $this->hasMany(Task::class) ;
    }
}
