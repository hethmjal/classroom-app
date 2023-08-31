<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name','user_id','classroom_id'
    ];


    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
    
    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class,'topic_id','id');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
