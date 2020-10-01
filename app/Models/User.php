<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\UserVerification;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\MediaLibrary\MediaCollections\File;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\Mail\ApiVerifyEmailNotification;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\Mail\ApiResetPasswordNotification;

class User extends Authenticatable implements JWTSubject, HasMedia, MustVerifyEmail
{
  use Notifiable, InteractsWithMedia, CanResetPassword;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'slug'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public static function boot()
  {
    parent::boot();

    static::creating(function (User $user) {
      $user = self::createUserSlug($user);
    });

    static::updating(function (User $user) {
      $user = self::createUserSlug($user);
    });
  }

  /**
   * Undocumented function
   *
   * @param User $user
   * @return void
   */
  public static function createUserSlug(User $user)
  {
    // produce a slug based on the activity title
    $slug = Str::slug($user->name);

    // check to see if any other slugs exist that are the same & count them
    $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

    // if other slugs exist that are the same, append the count to the slug
    $user->slug = $count ? "{$slug}-{$count}" : $slug;

    return $user;
  }
  /**
   * Undocumented function
   *
   * @param [type] $password
   * @return void
   */
  public function setPasswordAttribute($password)
  {
    if (trim($password) === '') {
      return;
    }
    $this->attributes['password'] = Hash::make($password);
  }

  /**
   * Undocumented function
   *
   * @param [type] $token
   * @return void
   * 
   * same as sendPasswordResetNotification
   */
  public function sendPasswordResetNotification($token)
  {
    $this->sendApiPasswordResetNotification($token);
  }
  public function sendApiPasswordResetNotification($token)
  {
    $this->notify(new ApiResetPasswordNotification($token));
  }

  /**
   * Undocumented function
   *
   * @return void
   * 
   * same as sendEmailVerificationNotification
   */
  public function sendApiEmailVerificationNotification()
  {
    $this->notify(new ApiVerifyEmailNotification); // my notification
  }

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
    return [];
  }

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public function categories()
  {
    return $this->hasMany(Category::class);
  }

  public function tags()
  {
    return $this->hasMany(Tag::class);
  }

  public function avatar()
  {
    return $this->getMedia('avatars')->first();
  }

  public function infos()
  {
    return $this->hasOne(UserInfo::class);
  }

  public function verification()
  {
    return $this->hasOne(UserVerification::class);
  }

  //Media Library
  public function registerMediaCollections(): void
  {
    $this
      ->addMediaCollection('avatars')
      ->acceptsFile(function (File $file) {
        return $file->size < 1024 * 1024 * 2;
      })
      ->singleFile();
  }
  public function registerMediaConversions(Media $media = null): void
  {
    $this->addMediaConversion('thumb')
      ->width(50)
      ->height(50)
      ->nonQueued();
  }
}
