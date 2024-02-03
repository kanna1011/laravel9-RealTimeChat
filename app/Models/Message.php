<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message_table';

    protected $fillable = ['name'];

    /**
     * ルームIDを元にメッセージを取得
     * 
     * @param int $roomId
     */
    public static function getMessage(int $roomId)
    {
        return self::where('room_id', $roomId)
            ->select('*')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
    }

    /**
     * メッセージ登録
     * 
     * @param array $data
     */
    public static function insertMessage(array $data)
    {
        return DB::table('message_table')->insert($data);
    }

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    }
}
