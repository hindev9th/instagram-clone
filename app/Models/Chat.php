<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /**
     * Fields that are mass assignable
     *
     * @var string[] $fillable
     */
    protected $fillable = ['chat'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * a chat room belong to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * a chat room belong to a profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

}
