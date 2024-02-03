<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Message;
use App\Models\Room;
use App\Events\MessageSent;
use Illuminate\Http\JsonResponse;
use carbon\CarbonImmutable;

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
        $data['created_at'] = CarbonImmutable::parse($datetime)->format('Y年m月d日 H:i');
        event(new MessageSent($data));

        return response()->json(['message' => '投稿しました。']);
    }
}
