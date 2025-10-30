<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserFile;
use App\Support\GeneralException;
use App\Repository\FileRepository;
use Illuminate\Database\Eloquent\Collection;

class FileService extends BaseService
{
    use GeneralException;

    public function __construct(
        private readonly FileRepository $fileRepository
    ) {}

    public function create(User $user, array $data): UserFile
    {
        return $this->fileRepository->create([
            'user_id' => $user->id,
            'file_name' => $data['file_name'],
            'description' => $data['description'],
            'file' => $data['file'],
            'expiration_date' => $data['expiration_date'],
        ]);
    }

    public function get(User $user): Collection
    {
        return $this->fileRepository->get('user_id', $user->id)->get();
    }

    public function update(UserFile $file, array $data):UserFile
    {
        $file->update([
            'file_name' => $data['file_name'],
            'description' => $data['description'],
            'file' => $data['file'],
            'expiration_date' => $data['expiration_date'],
        ]);

        return $file->refresh();
    }

    public function delete(UserFile $file)
    {
        $file->delete();
    }
}