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
     * @param string $userId
     * @return array
     */
    public static function getRoomListByUserId(string $userId): array
    {
        return self::where('user_id', $userId)
            ->select([
                'room_list_table.room_id', 'room_list_table.to_user_id', 'room_list_table.icon_path',
                'room_table.que_id', 'room_table.con_id', 'room_table.room_name', 'room_table.article_url', 'room_table.archive_flg'
            ])
            ->whereNull('room_list_table.deleted_at')
            ->join('room_table', function ($join) {
                $join->on('room_list_table.room_id', '=', 'room_table.id');
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
