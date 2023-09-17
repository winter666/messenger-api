<?php

namespace App\Http\Controllers;

use App\Models\Messenger\Chat\Chat;
use App\Repositories\Messenger\ChatRepository;
use App\Services\Http\Responses\JsonResponse;
use App\Services\Messenger\Chat\ChatService;
use App\Services\Messenger\Chat\MakeChatService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function pushToChat(Request $request, $chatId): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'user_id' => 'required|int|exists:users,id',
            'content' => 'required|string|max:500',
        ]);

        try {
            $userId = $request->get('user_id');
            $content = $request->get('content');

            /**
             * @var Chat $chat
             */
            $chat = Chat::query()->with(['users'])->findOrFail($chatId);
            $chat->users()->findOrFail($userId);
            $service = new ChatService($chat);
            $service->addUserMessage($userId, compact('content'));
            return JsonResponse::ok($service->queryChat(), 'item');
        } catch (ModelNotFoundException $e) {
            return JsonResponse::srcNotFound();
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), $e->getTrace());
        }

        return JsonResponse::serverError();
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'current_id' => 'required|int|exists:users,id',
            'user_id' => 'required|int|exists:users,id',
        ]);

        try {
            $personalization = [
                $request->user_id => ['hidden' => true],
                $request->current_id => ['hidden' => false],
            ];

            $service = (new MakeChatService(['background' => '#fff', 'personalization' => $personalization]))
                ->run()
                ->attachUsers($request->current_id, $request->user_id);

            return JsonResponse::ok($service->getChat(), 'item');
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), $e->getTrace());
        }

        return response()->json(['message' => 'Server error'], 500);
    }

    public function getOne(Request $request, ChatRepository $chatRepository, $chatId): \Illuminate\Http\JsonResponse
    {
        try {
            $chat = $chatRepository->getOne($chatId);
            return JsonResponse::ok($chat, 'item');
        } catch (ModelNotFoundException $e) {
            return JsonResponse::srcNotFound();
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), $e->getTrace());
        }

        return JsonResponse::serverError();
    }
}
