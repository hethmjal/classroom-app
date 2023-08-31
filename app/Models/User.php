<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements HasLocalePreference
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

/*     public function setEmailAttribute($value)
    {
        $this->attributes['first_name'] = strtolower($value);
    } */

   


    public function email(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value),
            set: fn($value) => strtolower($value)
        );
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value),
            set: fn($value) => strtolower($value)
        );
    }

    
    public function classrooms()
    {
        return $this->belongsToMany(
            Classroom::class, // related model
            'classroom_user', //pivot table
            'user_id', // foreign key for current model
            'classroom_id',// foreign key for related model
            'id', // primary key for current model
            'id', // primary key for related model
        )->withPivot(['role','created_at']);
           // ->as('join');//->wherePivot('enum','teacher');
    }

    public function createdClassrooms()
    {
        return $this->hasMany(Classroom::class,'user_id');
    }

    public function classworks()
    {
        return $this->belongsToMany(Classwork::class)
        ->using(ClassworkUser::class)
        ->withPivot(['grade','status','submitted_at','created_at']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function avatar()
    {
        return "https://ui-avatars.com/api/?background=random&color=fff&name=". str_replace(" ", "+", $this->name);
    }


    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class,'user_id','id')->withDefault();
    }

    public function routeNotificationForMail($driver, $notification = null)
    {
       // default return $this->email;
        //return $this->email; return $this->email_address; 
    }

    public function routeNotificationForVonage($driver, $notification = null)
    {
       return "970594557598";
    }

    public function routeNotificationForHadara()
    {
       return "970594557598";
    }


    public function preferredLocale(): string
    {
        return $this->profile->locale;
    }
}
