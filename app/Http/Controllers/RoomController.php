<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Room;
use App\Models\RoomList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

/**
 * メッセージルーム用コントローラー
 */
class RoomController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $userId = Auth::id();
        $roomLists = RoomList::getRoomListByUserId($userId);
        return view('chat.roomList', [
            "roomLists" => $roomLists
        ]);
    }
    /**
     *
     * @return View
     */
    public function create(Request $request)
    {
        $userId = Auth::id();
        $users = User::getUsers($userId);
        return view('chat.createRoom', [
            "users" => $users
        ]);
    }
    /**
     * @param Request $request
     * @return View
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $datetime = new CarbonImmutable();
        DB::beginTransaction();
        try {
            $insertRoomData = [
                "room_name" => $request->room_name,
                "created_at" => $datetime
            ];
            $roomId = Room::insertRoom($insertRoomData);
            $insertFromUser = [
                "room_id" => $roomId,
                "user_id" => $user->id,
                "created_at" => $datetime
            ];
            RoomList::insertRoomList($insertFromUser);
            foreach ($request->selected_users as $selectUserId) {
                $insertToUser = [
                    "room_id" => $roomId,
                    "user_id" => $selectUserId,
                    "created_at" => $datetime
                ];
                RoomList::insertRoomList($insertToUser);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return abort(500);
        }
        return redirect()->route('roomList.index');
    }
}
