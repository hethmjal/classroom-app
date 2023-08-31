<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id','first_name','gender','last_name','birthday','timezone','locale'];
    use HasFactory;

    protected $casta = [
        'birthday' => 'datetime'
    ];
    public function user()
    {
        return $this->hasOne(User::class,'user_id','id');
    }
}
