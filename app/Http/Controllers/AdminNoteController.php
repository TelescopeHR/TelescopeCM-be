<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminNoteRequest;
use App\Http\Resources\AdminNoteResource;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AdminNoteService;
use App\Support\ApiResponse;

class AdminNoteController extends Controller
{
    public function __construct(private readonly AdminNoteService $adminNoteService)
    {
        
    }

    public function index(Request $request, User $user)
    {
        $notes = $this->adminNoteService->getByUser($user->id);

        return (new ApiResponse())->success(
            'Admin notes retrieved successfully.',
            AdminNoteResource::collection($notes),
        );
    }

    public function types()
    {
        return (new ApiResponse())->success(
            'Admin note types retrieved successfully.',
            [
                'client_note_types' => array_keys(Note::CLIENT_NOTE_TYPES),
                'employee_note_types' => array_keys(Note::EMPLOYEE_NOTE_TYPES),
            ],
        );
    }
  
    public function store(AdminNoteRequest $request)
    {
        $data = $request->validated();

        return (new ApiResponse())->success(
            'Admin note created successfully.',
            new AdminNoteResource($this->adminNoteService->create($data)),
        );
    }

    public function update(AdminNoteRequest $request, Note $note)
    {
        $data = $request->validated();

        return (new ApiResponse())->success(
            'Admin note updated successfully.',
            new AdminNoteResource($this->adminNoteService->update($note, $data)),
        );
    }

    public function delete(Note $note)
    {
        $this->adminNoteService->delete($note);

        return (new ApiResponse())->success('Admin note deleted successfully.');
    }
}
