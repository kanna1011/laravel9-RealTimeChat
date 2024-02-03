<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'room_table';

    /**
     * idをもとにメッセージルームを取得
     * 
     * @param int $id
     * @return array
     */
    public static function getRoomById(int $id): array
    {
        return self::where('id', $id)
            ->select('*')
            ->whereNull('deleted_at')
            ->first()
            ->toArray();
    }
}
