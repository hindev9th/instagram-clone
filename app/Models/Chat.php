<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Chat extends Model
{
    use SoftDeletes;

    /**
     * Fields that are mass assignable
     *
     * @var string[] $fillable
     */
    protected $fillable = ['name'];

    protected $hidden = ['deleted_at'];

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

    public function scopeGetRoomByUser($query, $userIds)
    {
        return $query->join('chat_user as cu1', 'chats.id', '=', 'cu1.chat_id')
            ->whereIn('cu1.user_id', $userIds)
            ->whereNull('cu1.deleted_at')
            ->groupBy('cu1.chat_id')
            ->havingRaw('COUNT(DISTINCT cu1.user_id) = '.count($userIds))
            ->select('chats.*')
            ->where(function ($subquery) use ($userIds) {
                $subquery->whereExists(function ($innerSubquery) use ($userIds)  {
                    $innerSubquery->select(DB::raw(1))
                        ->from('chat_user as cu2')
                        ->whereColumn('cu2.chat_id', 'chats.id')
                        ->whereNull('cu2.deleted_at')
                        ->groupBy('cu2.chat_id')
                        ->havingRaw('COUNT(DISTINCT cu2.user_id) = '.count($userIds));
                });
            });
    }
}
