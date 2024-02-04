<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoomList extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'room_list_table';

    /**
     * user_idをもとにユーザが参加しているメッセージルームを取得
     * 
     * @param int $userId
     * @return array
     */
    public static function getRoomListByUserId(int $userId): array
    {
        return self::where('user_id', $userId)
            ->select([
                'room_list_table.*',
                'room_table.*'
            ])
            ->whereNull('room_list_table.deleted_at')
            ->join('room_table', function ($join) {
                $join->on('room_list_table.room_id', '=', 'room_table.id');
            })
            ->get()
            ->toArray();
    }

    /**
     * room_idをもとに相手ユーザを取得
     * 
     * @param int $roomId
     * @param int $userId
     * @return array
     */
    public static function getToUsers(int $roomId, int $userId): array
    {
        return self::where('room_id', $roomId)
            ->select('users.name')
            ->where('user_id', '<>', $userId)
            ->whereNull('room_list_table.deleted_at')
            ->join('users', function ($join) {
                $join->on('room_list_table.user_id', '=', 'users.id');
            })
            ->get()
            ->toArray();
    }

    /**
     * roomList登録
     * 
     * @param array $data
     */
    public static function insertRoomList(array $data)
    {
        return DB::table('room_list_table')->insert($data);
    }
}
