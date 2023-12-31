<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['post_id','user_id','parent_id','comment'];

    protected $with = ['user'];

    protected $appends = ['isLiked'];

    public function getIsLikedAttribute()
    {
        return auth()->user()->commentLikes->contains($this->id);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Comment::class,'parent_id')->with('replies')->withCount('likes');
    }
}
