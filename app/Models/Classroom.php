<?php

namespace App\Models;

use App\Models\Scopes\UserClassroomScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;
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

    protected static function booted()
    {
       /*  static::addGlobalScope('user',function(Builder $builder) {
            $builder->where('user_id',Auth::id());
        }); */

        static::addGlobalScope(new UserClassroomScope);
    
    }
    

   /*  public function getRouteKeyName(){
        return 'code';
    } */

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    public static function uploadCoverImage($file){
        $path = $file->store('/images','uploads');
        return $path;
    }

    public function deleteCoverImage($path){
        if ($path) {
            return Storage::disk('uploads')->delete($path);
        }
       
    }


    public function scopeActive(Builder $query,$status = 'active'){
        $query->where('status',$status);
    }

    public function join($user_id,$role = 'student'){
        DB::table('classroom_user')->insert([
            'classroom_id' => $this->id,
            'user_id' => $user_id,
            'role' => $role, 
            'created_at'=> now(),
         ]);
    }


}
