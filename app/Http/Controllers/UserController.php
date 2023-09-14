<?php

namespace App\Http\Controllers;

use App\Models\Messenger\Chat\Chat;
use App\Models\User;
use App\Services\Http\Responses\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getInfo(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $user = User::query()->with([
                'chats', 'chats.users',
                'chats.messages', 'chats.messages.user'
            ])->findOrFail($id);
            $chats = $user->chats->filter(function(Chat $chat) use ($user) {
                if (!empty($chat->personalization) && !empty($chat->personalization[$user->id])) {
                    return !$chat->personalization[$user->id]['hidden'];
                }

                return true;
            });

            $user->chats = $chats;
            return JsonResponse::ok($user, 'item');
        } catch(\Exception $e) {
            return JsonResponse::srcNotFound();
        }
    }

    public function getByEmailOrName(Request $request): \Illuminate\Http\JsonResponse
    {
        $emailOrName = $request->get('emailOrName');
        $users = User::query()
            ->where('email', 'like', $emailOrName.'%')
            ->orWhere('name', 'like', $emailOrName.'%')
            ->get();

        return response()->json($users);
    }
}
