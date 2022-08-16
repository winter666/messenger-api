<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>api</title>
        <style>
            .thread-container {
                width: 80%;
                margin-left: auto;
                margin-bottom: 10px;
            }
            .thread-controller {
                cursor: pointer;
                display: inline-block;
                padding: 0 8px 8px 8px;
            }
            .thread-controller:hover {
                color: darkcyan;
            }
            .message {
                margin-bottom: 10px;
                border-radius: 20px;
                background-color: darkcyan;
            }
            .message-head {
                border-bottom: 1px dashed #000000;
                padding: 12px;
                display: flex;
                justify-content: space-between;
            }
            .thread-collection {
                position: relative;
            }
            .thread-collection > .message {
                position: absolute;
                opacity: 0;
            }
            .thread-collection.on > .message {
                transition: 1s;
                opacity: 1;
                position: static;
            }
        </style>
    </head>
    <body class="antialiased">
        @php
            $user = \App\Models\User::query()->with([
                    'chats', 'chats.users', 'chats.messages',
                    'chats.messages.user',  'chats.messages.threads',
                    'chats.messages.threads.user',
                ])->first();
        @endphp

        @if (!is_null($user) && $user->chats->count())
            @foreach($user->chats as $chat)
                <div>
                    @php $participant = $chat->users->where('id', '!=', $user->id)->first() @endphp
                    Chat with {{ $participant->name }} &lt;{{ $participant->email }}&gt;
                    <div style="background-color: {{ $chat->background }}">
                        <span style="background-color: #2d3748; color: #e2e8f0; border-bottom-right-radius: 10px; display: inline-block; padding: 12px">Messages:</span>
                        <div>
                            @foreach($chat->messages as $message)
                                <div style="margin: 30px;">
                                    <div class="message">
                                        <div class="message-head">
                                            <div>{{ $message->user->name }}</div>
                                            <div style="opacity: .6">{{ $message->created_at->format('Y-m-d H:i') }}</div>
                                        </div>
                                        <div style="padding: 10px">
                                            {{ $message->content }}
                                        </div>
                                    </div>
                                    @if ($message->threads->count())
                                        <div class="thread-container">
                                            <span class="thread-controller" data-message-id="{{ $message->id }}" data-status="on">collapse all</span>
                                            <div class="thread-collection on" id="threads-{{ $message->id }}">
                                                @foreach($message->threads as $thread)
                                                    <div class="message">
                                                        <div class="message-head">
                                                            <div>{{ $thread->user->name }}</div>
                                                            <div style="opacity: .6">{{ $thread->created_at->format('Y-m-d H:i') }}</div>
                                                        </div>
                                                        <div style="padding: 10px">
                                                            {{ $thread->content }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    <script>
        const toggleCollapse = (e) => {
            const target = e.currentTarget;
            const messageId = target.dataset.messageId;
            const threadCollection = document.querySelector(`#threads-${messageId}`);
            const onStatus = threadCollection.classList.contains('on');
            if (onStatus) {
                target.innerText = 'expand all';
            } else {
                target.innerText = 'collapse all';
            }

            threadCollection.classList.toggle('on');

        };
        const ready = () => {
            const collapsers = document.querySelectorAll('.thread-controller');
            collapsers.forEach(c => {
                c.addEventListener('click', toggleCollapse);
            });
        }

        document.addEventListener("DOMContentLoaded", ready);
    </script>
    </body>
</html>
