<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $fillable = [
        'name',
        'order',
        'parent_id',
    ];

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public static function boot()
    {
        parent::boot();

        // static::creating(function(Category $category){
        //     // produce a slug based on the activity title
        //     $slug = Str::slug($category->name);

        //     // check to see if any other slugs exist that are the same & count them
        //     $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        //     // if other slugs exist that are the same, append the count to the slug
        //     $category->slug = $count ? "{$slug}-{$count}" : $slug;
        // });
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id'); //foreign key, primary key
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function scopeParents(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

    public function scopeOrdered(Builder $builder, $direction = 'asc')
    {
        $builder->orderBy('order', $direction);
    }
}
