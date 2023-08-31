<?php

namespace App\Models;

use App\Enums\ClassworkType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
class Classwork extends Model
{
    use HasFactory;
    
    const TYPE_ASSIGNMENT = ClassworkType::ASSIGNMENT;
    const TYPE_QUESTION = ClassworkType::QUESTION;
    const TYPE_MATERIAL = ClassworkType::MATERIAL;

    const TYPE_PUBLISHED = 'published';
    const TYPE_DRAFT = 'draft';

    protected static function booted(){
        static::creating(function(Classwork $classwork){
            if(!$classwork->published_at){
                $classwork->published_at = now();
            }
        });
    }

    protected $fillable = [
        'user_id','classroom_id','topic_id','title','description',
        'type','status','options','published_at'
    ];

    protected $casts = [
        'options' => 'json',
        'published_at' => 'datetime',
        'type' => ClassworkType::class,
    ];

    public function scopeFilter($builder,$filters)
    {

        $builder->when($filters['search'] ?? '', function($builder,$value){
            $builder->where(function($builder) use ($value){
                $builder->where('title','LIKE',"%{$value}%")
                ->orWhere('description','LIKE',"%{$value}%");
            });
            
        })
        ->when($filters['type'] ?? '', function($builder,$value){
            $builder->where('type','=',$value);
        }); 
        
    }


    public function getPublishDateAttribute(){
        if($this->published_at){
            return $this->published_at->format("Y-m-d");
        }
    }
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class,'classroom_id','id');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class,'topic_id','id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


    public function users()
    {
        return $this->belongsToMany(User::class)
        ->withPivot(['grade','submitted_at','status','created_at'])
        ->using(ClassworkUser::class);
    }


    public function comments(){
        return $this->MorphMany(Comment::class,'commentable')->latest();
    }


    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

}
