<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Message;
use App\Models\Room;
use App\Models\RoomList;
use App\Events\MessageSent;
use Illuminate\Http\JsonResponse;
use carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * @param Request $request
     * @param int $room_id ルームID
     * @return View
     */
    public function index(Request $request, int $room_id) : View
    {
        $userId = $request->session()->get('user_id');
        $userName = $request->session()->get('user_name');
        $toUser = null;
        if (!$userId) {
            return abort(404);
        }
        $room = Room::getRoomById($room_id);
        if ($room['que_id'] === $userId) {
            $toUser = $room['con_id'];
        }
        elseif ($room['con_id'] === $userId) {
            $toUser = $room['que_id'];
        }
        if (is_null($toUser)) {
            return abort(404);
        }
        $messages = Message::getMessage($room_id);
        return view('chat.messageRoom',[
            "messages" => $messages,
            "room" => $room,
            "from_user" => $userId,
            "to_user" => $toUser,
            "from_user_name" => $userName
        ]);
    }
    
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        $datetime = new CarbonImmutable();
        $data = [
            "room_id" => $request->room_id,
            "user_id" => $request->user_id,
            "user_name" => $request->user_name,
            "content" => $request->content,
            "created_at" => $datetime
        ];
        Message::insertMessage($data);
        $data['created_at'] = CarbonImmutable::parse($datetime)->setTimezone('Asia/Tokyo')->format('Y年m月d日 H:i');
        event(new MessageSent($data));

        return response()->json(['message' => '投稿しました。']);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function roomCreate(Request $request)
    {
        $request->session()->put('user_id',  $request->user_id);
        $request->session()->put('user_name', $request->user_name);
        $datetime = new CarbonImmutable();
        DB::beginTransaction();
        try {
            $insertRoomData = [
                "que_id" => $request->user_id,
                "con_id" => $request->con_id,
                "room_name" => $request->room_name,
                "article_url" => $request->article_url,
                "archive_flg" => 0,
                "created_at" => $datetime
            ];
            $roomId = Room::insertRoom($insertRoomData);
            if (empty($roomId)) {
                DB::rollBack();
                return abort(500);
            }
            $insertFromUser = [
                "room_id" => $roomId,
                "user_id" => $request->user_id,
                "to_user_id" => $request->con_id,
                "created_at" => $datetime
            ];
            $insertToUser = [
                "room_id" => $roomId,
                "user_id" => $request->con_id,
                "to_user_id" => $request->user_id,
                "created_at" => $datetime
            ];
            RoomList::insertRoomList($insertFromUser);
            RoomList::insertRoomList($insertToUser);
            $messageData = [
                "room_id" => $roomId,
                "user_id" => $request->user_id,
                "user_name" => $request->user_name,
                "content" => $request->content,
                "created_at" => $datetime
            ];
            Message::insertMessage($messageData);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return abort(500);
        }
        $messages = Message::getMessage($roomId);
        $room = Room::getRoomById($roomId);
        return view('chat.messageRoom',[
            "messages" => $messages,
            "room" => $room,
            "from_user" => $request->user_id,
            "to_user" => $request->con_id,
            "from_user_name" => $request->user_name
        ]);
    }
}
