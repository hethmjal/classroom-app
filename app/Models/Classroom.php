<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'section',
        'code',
        'subject',
        'room',
        'cover_image_path',
        'theme',
        'user_id',
        'status'
    ];

    public function getRouteKeyName(){
        return 'code';
    }

    public function topics(){
        return $this->hasMany(Topic::class);
    }
}
