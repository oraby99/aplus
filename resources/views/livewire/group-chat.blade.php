<div style="display: flex; flex-direction: column; height: 100%; border-radius: 1.5rem; overflow: hidden; background: #1e1b4b; border: 4px solid #3730a3; position: relative;">
    <style>
        @keyframes popIn {
            0% { transform: scale(0.8) translateY(10px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        .chat-space-bg {
            background-color: #1e1b4b; /* deep space blue */
            position: relative;
        }
        .chat-space-bg::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                radial-gradient(circle at 10% 20%, #fff 1px, transparent 2px),
                radial-gradient(circle at 90% 10%, #fff 2px, transparent 3px),
                radial-gradient(circle at 30% 50%, #fde047 1px, transparent 2px),
                radial-gradient(circle at 70% 60%, #fff 2px, transparent 3px),
                radial-gradient(circle at 20% 80%, #fde047 1.5px, transparent 2.5px),
                radial-gradient(circle at 80% 90%, #fff 1px, transparent 2px);
            z-index: 0;
        }
        .chat-space-bg::after {
            content: '';
            position: absolute;
            bottom: -30px; left: -10%; right: -10%;
            height: 150px;
            background-image: 
                radial-gradient(circle at 20% 100%, #312e81 60px, transparent 61px),
                radial-gradient(circle at 50% 90%, #312e81 80px, transparent 81px),
                radial-gradient(circle at 80% 100%, #312e81 70px, transparent 71px);
            z-index: 0;
            filter: drop-shadow(0 -5px 10px rgba(0,0,0,0.2));
            opacity: 0.8;
        }
        .msg-bubble {
            animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: pre-wrap;
        }
        .msg-sent {
            background: linear-gradient(135deg, #a855f7 0%, #8b5cf6 100%);
            color: white;
            border-radius: 20px 20px 0px 20px;
        }
        .msg-received {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-radius: 20px 20px 20px 0px;
        }
    </style>
    <!-- Messages Area -->
    <div class="chat-space-bg" style="flex: 1; overflow-y: auto; padding: 1.5rem;" wire:poll.2s>
        @forelse($messages as $message)
            <div style="display: flex; margin-bottom: 1.5rem; justify-content: {{ $message->user_id === auth()->id() ? 'flex-end' : 'flex-start' }}; position: relative; z-index: 1;">
                <div style="display: flex; flex-direction: column; max-width: 85%; align-items: {{ $message->user_id === auth()->id() ? 'flex-end' : 'flex-start' }}">
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem; {{ $message->user_id === auth()->id() ? 'flex-direction: row-reverse;' : '' }}">
                        <div style="width: 28px; height: 28px; border-radius: 50%; background-color: white; display: flex; align-items: center; justify-content: center; color: #1e1b4b; font-weight: bold; font-size: 0.75rem; border: 2px solid #8b5cf6; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            {{ mb_substr($message->user->name, 0, 1) }}
                        </div>
                        <span style="font-size: 0.8rem; font-weight: bold; color: #a5b4fc;">{{ $message->user->name }}</span>
                    </div>

                    <div class="msg-bubble {{ $message->user_id === auth()->id() ? 'msg-sent' : 'msg-received' }}" style="padding: 0.75rem 1.25rem; font-size: 1rem; line-height: 1.5;">
                        {{ $message->body }}
                    </div>
                    <span style="font-size: 0.7rem; font-weight: bold; color: #6366f1; margin-top: 0.5rem; padding: 0 0.5rem;">{{ $message->created_at->format('H:i') }}</span>
                </div>
            </div>
        @empty
            <div style="display: flex; flex-direction: column; height: 100%; align-items: center; justify-content: center; color: #818cf8; position: relative; z-index: 1;">
                <svg style="width: 4rem; height: 4rem; color: #4f46e5; margin-bottom: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span style="font-size: 1.1rem; font-weight: bold;">{{ __('لا توجد رسائل حتى الآن!') }}</span>
                <span style="font-size: 0.9rem;">{{ __('كن أول من يرسل رسالة فضائية 🚀') }}</span>
            </div>
        @endforelse
    </div>

    <!-- Input Area -->
    <div style="padding: 1rem; background-color: #312e81; position: relative; z-index: 2; border-top: 2px dashed #4338ca;">
        <form wire:submit.prevent="sendMessage" style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="flex: 1; position: relative;">
                <input type="text" wire:model="body" placeholder="{{ __('اكتب رسالتك الفضائية هنا... 🪐') }}" style="width: 100%; border-radius: 9999px; border: none; background-color: rgba(255,255,255,0.95); color: #1e1b4b; padding: 1rem 1.5rem; font-size: 1rem; font-weight: bold; outline: none; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);" required>
            </div>
            <button type="submit" style="padding: 1rem; border-radius: 50%; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.4); transition: transform 0.2s;" wire:loading.attr="disabled" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </form>
    </div>
</div>
