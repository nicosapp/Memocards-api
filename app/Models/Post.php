<?php

namespace App\Models;

use App\Models\Tag;
use App\Scoping\Scoper;
use App\Models\Category;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
  use  InteractsWithMedia;

  protected $fillable = [
    'post_title',
    'post_content',
    'viewed',
    'is_favorite',
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

    static::creating(function (Post $post) {
      $post->uuid = Str::uuid();
    });

    static::updating(function (Post $post) {
      $post->post_excerpt = Str::words(strip_tags($post->post_content), 60);
    });
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

  public function categories()
  {
    return $this->belongsToMany(Category::class);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }

  //Scope
  public function scopePublic(Builder $builder)
  {
    return $builder->where('is_public', true);
  }
  public function scopeFavorite(Builder $builder)
  {
    return $builder->where('is_favorite', true);
  }
  public function scopeMostViewed(Builder $builder)
  {
    return $builder->latest('viewed');
  }
  public function scopeLastCreated(Builder $builder)
  {
    return $builder->latest('created_at');
  }
  public function scopeLastUpdated(Builder $builder)
  {
    return $builder->latest('updated_at');
  }

  //Scope with scope
  public function scopeWithScopes(Builder $builder, $scopes = [])
  {
    return (new Scoper(request()))->apply($builder, $scopes);
  }
}
