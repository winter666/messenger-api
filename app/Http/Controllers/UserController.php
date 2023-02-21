<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Http\Responses\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getInfo(Request $request, $id)
    {
        try {
            $user = User::query()->with([
                'chats', 'chats.users',
                'chats.messages', 'chats.messages.user'
            ])->findOrFail($id);
            return JsonResponse::ok($user, 'item');
        } catch(\Exception $e) {
            Log::debug($e->getMessage(), $e->getTrace());
        }

        return JsonResponse::srcNotFound();
    }
}
