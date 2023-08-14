<?php

namespace App\Models;

use App\Mail\NewUserWelcome;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','username', 'password','api_token'
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

    /**
     * always load attributes of user
     *
     * @var string[] $with
     */
    protected $with = ['profile'];

    /**
     * load custom attribute of user;
     *
     * @var string[] $appends
     */
    protected $appends = ['isFollowed'];

    /**
     * create a profile null for new user and send to an email welcome
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user){
            $user->profile()->create([
                'title' => $user->name,
            ]);

//            Mail::to($user->email)->send(new NewUserWelcome());
        });
    }

    public function getIsFollowedAttribute()
    {
        return auth()->user()->following->contains($this->id);
    }

    /**
     * a user has a profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * a user belong to many following profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    /**
     * a user can have many post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at','DESC');
    }

    public function commentLikes()
    {
        return $this->belongsToMany(Comment::class);
    }

    /**
     * a user can have many comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * a user belong to many like post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * a user can have many messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * a user belong to many chat rooms
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function chats()
    {
        return $this->belongsToMany(Chat::class)->wherePivotNull("deleted_at")->withTimestamps();
    }
}
