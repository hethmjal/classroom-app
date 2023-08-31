<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','commentable_id','commentable_type','ip','user_agent','content'];


    protected $with = [
        'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(
            ['name'=>'deleted user',]
        );
    }


    public function commentable ()
    {
        return $this->morphTo();
    }
}
