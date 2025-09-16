<?php

namespace App\Services;

use App\Models\User;
use App\Support\HttpCode;
use Illuminate\Http\Request;
use App\Support\GeneralException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class AuthService extends Service
{
    use GeneralException;

    public ?User $user;
    public array $data;

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function login(array $data): User
    {
        return $this->setData($data)
            ->setUser()
            ->attempt();
    }

    public function logout(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }

    /**
     * @return $this
     */
    protected function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return $this
     */
    protected function setUser(): self
    {
        $this->user = $this->model->where('email', $this->data['email'])->first();

        return $this;
    }

    protected function attempt(): User
    {
        try {
            if ((empty($this->user) || $this->user instanceof Builder) || ! Hash::check($this->data['password'], $this->user->password)) {
                $this->exception('invalid credentials', HttpCode::HTTP_BAD_REQUEST);
            } else {
                $this->user->update(['last_login_at' => now()]);
            }
        } catch (\Throwable $th) {
            Log::error("Error logging in user {$th->getMessage()}");
            $this->exception('Error logging in user', HttpCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->user;
    }
}