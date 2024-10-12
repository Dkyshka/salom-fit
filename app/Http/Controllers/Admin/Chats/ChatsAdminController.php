<?php

namespace App\Http\Controllers\Admin\Chats;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatAdminRequest;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatsAdminController extends Controller
{
    public function index()
    {
        $channels = Chat::orderBy('id')->paginate(15);

        return view('admin.chats.index', compact('channels'));
    }

    public function create()
    {
        return view('admin.chats.chat-create');
    }

    public function store(ChatAdminRequest $chatAdminRequest)
    {
        try {
            Chat::create($chatAdminRequest->validated());

            return redirect(route('channels_admin'))
                ->with('success', 'Канал успешно создан');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при добавлении: ' . $e->getMessage()]);
        }
    }

    public function edit(Chat $chat)
    {
        return view('admin.chats.chat-edit', compact('chat'));
    }

    public function update(Chat $chat, ChatAdminRequest $chatAdminRequest)
    {
        try {
            $chat->update($chatAdminRequest->validated());

            return redirect(route('channels_admin'))
                ->with('success', 'Канал успешно обновлен');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при обновлении: ' . $e->getMessage()]);
        }
    }

    public function destroy(Chat $chat)
    {
        try {
            $chat->delete();

            return redirect(route('channels_admin'))
                ->with('success', 'Канал успешно удален');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ошибка при удалении: ' . $e->getMessage()]);
        }
    }
}
