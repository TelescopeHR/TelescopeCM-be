<?php

namespace App\Services;

use App\Models\Note;
use App\Repository\AdminNoteRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class AdminNoteService
{
    public function __construct(
        private readonly AdminNoteRepository $adminNoteRepository,
        private readonly EmployeeService $employeeService,
        private readonly ClientService $clientService,
    )
    {

    }

    public function create(array $data): Note
    {
        $user_id = null;
        if($data['mode'] === 'employee') {
            $user_id = $this->employeeService->findById($data['employee_id'])?->id;
        } else {
            $user_id = $this->clientService->findOne($data['client_id'])?->id;
        }

        return $this->adminNoteRepository->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => Note::CLIENT_NOTE_TYPES[$data['type']] ?? Note::EMPLOYEE_NOTE_TYPES[$data['type']],
            'created_by' => Auth::id(),
            'user_id' => $user_id,
        ]);
    }

    public function getByUser(string $user_id): Collection
    {
        return $this->adminNoteRepository->getBy('user_id', $user_id)->get();
    }

    public function update(Note $note, array $data): Note
    {
        $note->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => Note::CLIENT_NOTE_TYPES[$data['type']] ?? Note::EMPLOYEE_NOTE_TYPES[$data['type']],
        ]);

        return $note->refresh();
    }

    public function delete(Note $note): void
    {
        $note->delete();
    }
}