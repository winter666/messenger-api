<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Http\Responses\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getInfo(Request $request, UserRepository $userRepository, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $userRepository->getInfo($id);
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
