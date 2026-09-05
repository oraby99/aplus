<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\Message;
use Livewire\Component;
use Livewire\WithFileUploads;

class GroupChat extends Component
{
    use WithFileUploads;

    public Group $group;
    public string $body = '';
    public $image = null;

    protected function rules(): array
    {
        return [
            'body' => 'nullable|string|max:2000',
            'image' => 'nullable|image|max:10240', // 10MB max
        ];
    }

    public function mount(Group $group)
    {
        $this->group = $group;
    }

    public function removeImage()
    {
        $this->image = null;
    }

    public function sendMessage()
    {
        // Don't send if both body and image are empty
        if (trim($this->body) === '' && !$this->image) {
            return;
        }

        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('chat_images', 'public');
        }

        Message::create([
            'group_id' => $this->group->id,
            'user_id' => auth()->id(),
            'body' => trim($this->body) !== '' ? $this->body : null,
            'image_path' => $imagePath,
        ]);

        $this->body = '';
        $this->image = null;
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
