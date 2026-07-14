<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\Message;
use Livewire\Component;

class GroupChat extends Component
{
    public Group $group;
    public string $body = '';

    protected $rules = [
        'body' => 'required|string|max:1000',
    ];

    public function mount(Group $group)
    {
        $this->group = $group;
    }

    public function sendMessage()
    {
        $this->validate();

        Message::create([
            'group_id' => $this->group->id,
            'user_id' => auth()->id(),
            'body' => $this->body,
        ]);

        $this->body = '';
    }

    public function render()
    {
        $messages = Message::where('group_id', $this->group->id)
            ->with('user')
            ->latest()
            ->take(50)
            ->get()
            ->reverse();

        return view('livewire.group-chat', [
            'messages' => $messages,
        ]);
    }
}
