<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\Homework;
use Livewire\Component;
use Livewire\WithFileUploads;

class GroupHomework extends Component
{
    use WithFileUploads;

    public Group $group;

    // Student upload fields
    public string $title = '';
    public string $description = '';
    public string $link_url = '';
    public $file = null;

    // Teacher/Admin Evaluation fields
    public ?int $evaluatingId = null;
    public ?int $score = null;
    public string $feedback = '';
    public string $status = 'approved';

    public ?string $successMessage = null;
    public ?string $errorMessage = null;

    public function mount(Group $group): void
    {
        $this->group = $group;
    }

    public function submitHomework(): void
    {
        $this->successMessage = null;
        $this->errorMessage = null;

        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'link_url' => 'nullable|url|max:255',
            'file' => 'nullable|file|max:51200', // max 50MB
        ], [
            'title.required' => 'يرجى إدخال عنوان للواجب أو المشروع.',
            'link_url.url' => 'يرجى إدخال رابط صحيح (يبدأ بـ https://).',
            'file.max' => 'الحد الأقصى لحجم الملف هو 50 ميجابايت.',
        ]);

        if (empty($this->file) && empty($this->link_url)) {
            $this->addError('file', 'يرجى إرفاق ملف الواجب أو وضع رابط للمشروع.');
            return;
        }

        $filePath = null;
        $fileName = null;

        if ($this->file) {
            $fileName = $this->file->getClientOriginalName();
            $filePath = $this->file->store('homeworks', 'public');
        }

        Homework::create([
            'group_id' => $this->group->id,
            'student_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'link_url' => $this->link_url ?: null,
            'status' => 'pending',
        ]);

        $this->reset(['title', 'description', 'link_url', 'file']);
        $this->successMessage = 'تم تسليم الواجب بنجاح! سيقوم المعلم بمراجعته وتقييمه قريباً 🚀';
    }

    public function startEvaluation(int $id): void
    {
        $homework = Homework::where('group_id', $this->group->id)->findOrFail($id);
        $this->evaluatingId = $homework->id;
        $this->score = $homework->score ?? 100;
        $this->status = $homework->status === 'pending' ? 'approved' : $homework->status;
        $this->feedback = $homework->feedback ?? '';
    }

    public function cancelEvaluation(): void
    {
        $this->reset(['evaluatingId', 'score', 'status', 'feedback']);
    }

    public function saveEvaluation(): void
    {
        if (!$this->evaluatingId) {
            return;
        }

        $this->validate([
            'score' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:approved,needs_revision,pending',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $homework = Homework::where('group_id', $this->group->id)->findOrFail($this->evaluatingId);
        $homework->update([
            'score' => $this->score,
            'status' => $this->status,
            'feedback' => $this->feedback,
            'teacher_id' => auth()->id(),
            'evaluated_at' => now(),
        ]);

        $this->cancelEvaluation();
        $this->successMessage = 'تم حفظ تقييم الواجب بنجاح! ✨';
    }

    public function deleteSubmission(int $id): void
    {
        $homework = Homework::where('group_id', $this->group->id)->findOrFail($id);

        // Allow student to delete their own pending submission, or teacher/admin to delete
        if (auth()->user()->type === 'student' && $homework->student_id !== auth()->id()) {
            abort(403);
        }

        $homework->delete();
        $this->successMessage = 'تم حذف التسليم بنجاح.';
    }

    public function render()
    {
        $isStudent = auth()->user()?->type === 'student';

        if ($isStudent) {
            $submissions = Homework::where('group_id', $this->group->id)
                ->where('student_id', auth()->id())
                ->latest()
                ->get();
        } else {
            $submissions = Homework::where('group_id', $this->group->id)
                ->with(['student', 'teacher'])
                ->latest()
                ->get();
        }

        return view('livewire.group-homework', [
            'group' => $this->group,
            'submissions' => $submissions,
            'isStudent' => $isStudent,
            'successMessage' => $this->successMessage,
            'errorMessage' => $this->errorMessage,
            'evaluatingId' => $this->evaluatingId,
        ]);
    }
}
