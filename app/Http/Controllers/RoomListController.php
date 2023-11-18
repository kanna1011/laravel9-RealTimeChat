<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\RoomList;

/**
 * メッセージルーム一覧用コントローラー
 */
class RoomListController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request) : View
    {
        $roomLists = $this->getRoomListByUserId($request);
        return view('chat.roomList',[
            "roomLists" => $roomLists
        ]);
    }

    /**
     * 指定されたuser_idからroomlistを取得
     * 
     * @param Request $request
     * @return array $roomList
     */
    public function getRoomListByUserId(Request $request)
    {
        $userId = $request->input('user_id');
        $roomList = RoomList::getRoomListByUserId($userId);

        return $roomList;
    }
}
