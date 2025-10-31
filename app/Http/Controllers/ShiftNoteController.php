<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftNoteRequest;
use App\Http\Resources\ShiftNoteResource;
use App\Models\MoodType;
use App\Models\ShiftNote;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use App\Services\ShiftNoteService;

class ShiftNoteController extends Controller
{
    public function __construct(private readonly ShiftNoteService $shiftNoteService)
    {
        
    }

    public function index(User $user, Request $request)
    {
        $paginate = $request->boolean('paginate', false);
        $pageNumber = $request->integer('page', 1);
        $perPage = $request->integer('per_page');

        $notes = $this->shiftNoteService->get($user, [], $paginate, $pageNumber, $perPage);

        if ($paginate) {
            return (new ApiResponse())->paginate("Success fetching employee notes", $notes);
        }

        return (new ApiResponse())->success('Success fetching employee notes', ShiftNoteResource::collection($notes));
    }

    public function moodTypes()
    {
        return (new ApiResponse())->success('Success fetching mood types', MoodType::all());
    }

    // public function store(User $user, FileRequest $request)
    // {
    //     $data = $request->validated();

    //     return (new ApiResponse())->success('Success creating file', new FileResource($this->shiftNoteService->create($user, $data)));
    // }

    public function update(ShiftNote $note, ShiftNoteRequest $request)
    {
        $data = $request->validated();

        return (new ApiResponse())->success('Success updating note', new ShiftNoteResource($this->shiftNoteService->update($note, $data)));
    }

    public function delete(ShiftNote $note)
    {
        $this->shiftNoteService->delete($note);
        return (new ApiResponse())->success('Success deleting note');
    } 
}
