<?php

namespace App\Models;

use App\Models\Scopes\UserClassroomScope;
use App\Observers\ClassroomObserver;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
       
  
        static::addGlobalScope(new UserClassroomScope);
    /*  static::addGlobalScope('user',function(Builder $builder) {
            $builder->where('user_id',Auth::id());
        }); */

                    

        static::observe(ClassroomObserver::class);
      
        /* static::creating(function(Classroom $classroom){
            $classroom->code =  Str::random(8);
            $classroom->user_id = Auth::id();
        });

        static::forceDeleted(function(Classroom $classroom){
            if ($classroom->cover_image_path) {
                return Storage::disk('uploads')->delete($classroom->cover_image_path);
            }
        });
    
        static::deleted(function(Classroom $classroom){
            $classroom->status =  'deleted';
            $classroom->save();
        });

        static::restored(function(Classroom $classroom){
            $classroom->status =  'active';
            $classroom->save();
        }); */
    }
    

   /*  public function getRouteKeyName(){
        return 'code';
    } */

    

    public static function uploadCoverImage($file){
        $path = $file->store('/images','uploads');
        return $path;
    }

    public function deleteCoverImage($path){
        
       
    }


    public function scopeActive(Builder $query,$status = 'active'){
        $query->where('status',$status);
    }

    public function join($user_id,$role = 'student'){

        $exists = $this->users()->where('id',$user_id)->exists();
        if($exists){
            throw new Exception('User already joined classroom');
       }
        return $this->users()->attach($user_id,[
            'role' => $role, 
            'created_at'=> now(),
        ]);  

   
        /* DB::table('classroom_user')->insert([
            'classroom_id' => $this->id,
            'user_id' => $user_id,
            'role' => $role, 
            'created_at'=> now(),
         ]); */
    }

    public function getNameAttribute($value){
        return strtoupper($value);
    }


    public function getCoverImageUrlAttribute(){
        if ($this->cover_image_path) {
           return asset('uploads/'.$this->cover_image_path);
        }
        return "https://placehold.co/400x150@2x.png";
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class,'classroom_id','id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class, // related model
            'classroom_user', //pivot table
            'classroom_id', // foreign key for current model
            'user_id',// foreign key for related model
            'id', // primary key for current model
            'id', // primary key for related model
        )->withPivot(['role','created_at']);
           // ->as('join');//->wherePivot('role','teacher');
    }

    public function teachers()
    {
        return $this->users()->wherePivot('role','teacher');
    }

    public function students()
    {
        return $this->users()->wherePivot('role','student');
    }


    public function streams(): HasMany
    {
        return $this->hasMany(Stream::class)->latest();
    }
}
