<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserFile;
use App\Models\ShiftNote;
use App\Models\VisitTask;
use App\Support\GeneralException;
use Illuminate\Support\Facades\DB;
use App\Repository\ShiftNoteRepository;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ShiftNoteResource;
use Illuminate\Database\Eloquent\Collection;

class ShiftNoteService extends BaseService
{
    use GeneralException;

    public function __construct(
        private readonly ShiftNoteRepository $shiftNoteRepository
    ) {}

    public function create(User $user, array $data): UserFile
    {
        return $this->shiftNoteRepository->create([
            'user_id' => $user->id,
            'file_name' => $data['file_name'],
            'description' => $data['description'],
            'file' => $data['file'],
            'expiration_date' => $data['expiration_date'],
        ]);
    }

    public function get(User $user, array $filters, bool $paginate, int $pageNumber, int $perPage): Collection|array
    {
        $query = $this->shiftNoteRepository->get('user_id', $user->id);

        return $paginate ? $this->paginate($query, function (Model $shift_note) {
            return new ShiftNoteResource($shift_note);
        }, $pageNumber, $perPage ?? config('env.no_of_paginated_record')) : $query->get();
    }

    public function update(ShiftNote $note, array $data):ShiftNote
    {
        return DB::transaction(function () use ($note, $data) {
            $visit = $note->visit;

            $note->message = $data['message'] ?? '';
            $note->save();

            if (!empty($data['care_needs']) && is_array($data['care_needs'])) {
                VisitTask::where('visit_id', $note->visit_id)->delete();
                foreach ($data['care_needs'] as $name) {
                    VisitTask::create([
                        'visit_id' => $visit->id,
                        'task_name' => $name,
                    ]);
                }
            }

            if (!empty($data['mood_type'])) {
                $visit->moodTypes()->sync([$data['mood_type']]);
            }
            return $note->refresh();
        });
    }

    public function delete(ShiftNote $note)
    {
        $note->delete();
    }
}