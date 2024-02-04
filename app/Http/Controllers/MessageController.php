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
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * @param Request $request
     * @param int $room_id ルームID
     * @return View
     */
    public function index(Request $request, int $room_id): View
    {
        $user = Auth::user();

        $room = Room::getRoomById($room_id);
        $messages = Message::getMessage($room_id);
        $users = RoomList::getToUsers($room_id, $user->id);
        $flatUsers = array_map(fn ($user) => $user["name"], $users);
        $toUsers = implode(",", $flatUsers);
        return view('chat.messageRoom', [
            "messages" => $messages,
            "room" => $room,
            "from_user" => $user->id,
            "to_user" => $toUsers,
            "from_user_name" => $user->name
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $datetime = new CarbonImmutable();
        $data = [
            "room_id" => $request->room_id,
            "user_id" => $request->user_id,
            "content" => $request->content,
            "created_at" => $datetime
        ];
        Message::insertMessage($data);
        $data['created_at'] = CarbonImmutable::parse($datetime)->setTimezone('Asia/Tokyo')->format('Y年m月d日 H:i');
        $data += [
            "user_name" => $request->user_name,
        ];
        event(new MessageSent($data));

        return response()->json(['message' => '投稿しました。']);
    }
}
