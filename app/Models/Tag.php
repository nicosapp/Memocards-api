<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public static function boot()
    {
        parent::boot();

        // static::creating(function(Tag $tag){
        //     self::handleSlug($tag);
        // });
        // static::updating(function(Tag $tag){
        //     self::handleSlug($tag);
        // });
    }

    public static function handleSlug(Tag $tag){
        // produce a slug based on the activity title
        if(trim($tag->slug) === ''){
            $slug = Str::slug( $tag->name );
        } else {
            $slug = Str::slug($tag->slug);
        }

        // check to see if any other slugs exist that are the same & count them
        $user_id = $tag->user_id;
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$' AND user_id = {$user_id}")->count();

        // if other slugs exist that are the same, append the count to the slug
        $tag->slug = $count ? "{$slug}-{$count}" : $slug;
        $tag;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
