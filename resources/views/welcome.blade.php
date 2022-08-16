<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>api</title>
    </head>
    <body class="antialiased">
        @php
            $user = \App\Models\User::query()->with(['chats', 'chats.users', 'chats.messages', 'chats.messages.user'])->first();
        @endphp

        @if (!is_null($user) && $user->chats->count())
            @foreach($user->chats as $chat)
                <div>
                    @php $participant = $chat->users->where('id', '!=', $user->id)->first() @endphp
                    Chat with {{ $participant->name }} &lt;{{ $participant->email }}&gt;
                    <div>
                        Messages:
                        <div>
                            @foreach($chat->messages as $message)
                                <div style="border: 1px solid black">
                                    <div
                                        style="border-bottom: 1px dashed black; padding: 10px">{{ $message->user->name }}</div>
                                    <div style="padding: 10px">
                                        {{ $message->content }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </body>
</html>
