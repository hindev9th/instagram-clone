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
    protected $fillable = ['name'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * a chat room belong to many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * check user_id have in the room
     *
     * @param int $user_id
     * @return bool
     */
    public function hasUser(int $user_id): bool
    {
        $user = $this->users()->where('id',$user_id)->first();

        return $user != null;
    }

}
