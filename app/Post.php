<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $fillable = [
        'post_title',
        'post_content',
        'uuid',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function(Post $post){
            $post->uuid = Str::uuid();
        });
        
        // static::created(function(Post $post) {
        //     $post->steps()->create([
        //         'order' => 1
        //     ]);
        // });
    }

    // public function steps()
    // {
    //     return $this->hasMany(Step::class)
    //         ->orderBy('order','asc');    
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublic(Builder $builder)
    {
        return $builder->where('is_public',true);
    }
}
