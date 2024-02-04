<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 登録
     * 
     * 
     */
    public static function insertUser(array $data)
    {
        $id = DB::table('room_list_table')->insertGetId($data);

        return self::where('id', $id);
    }

    /**
     * ログイン中以外のユーザを取得
     * 
     * @param int $id
     */
    public static function getUsers(int $id)
    {
        return self::where('id', '<>', $id)
            ->select(['id', 'name'])
            ->get()
            ->toArray();
    }
}
