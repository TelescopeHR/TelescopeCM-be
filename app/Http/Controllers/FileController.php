<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\User;
use App\Models\UserFile;
use App\Services\FileService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct(
        private readonly FileService $fileService
    )
    {

    }

    public function index(User $user)
    {
        return (new ApiResponse())->success('Success fetching files', FileResource::collection($this->fileService->get($user)));
    }

    public function store(User $user, FileRequest $request)
    {
        $data = $request->validated();

        return (new ApiResponse())->success('Success creating file', new FileResource($this->fileService->create($user, $data)));
    }

    public function update(UserFile $file, FileRequest $request)
    {
        $data = $request->validated();

        return (new ApiResponse())->success('Success updating file', new FileResource($this->fileService->update($file, $data)));
    }

    public function delete(UserFile $file)
    {
        $this->fileService->delete($file);
        return (new ApiResponse())->success('Success deleting file');
    }
}
