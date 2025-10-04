<?php

namespace App\Services;

use App\Models\User;
use App\Models\PhoneNumber;
use App\Services\BaseService;
use App\Support\GeneralException;
use Illuminate\Support\Facades\Log;

class PhoneNumberService extends BaseService
{
    use GeneralException;

    public ?PhoneNumber $model;

    public function __construct()
    {
        $this->model = new PhoneNumber();
    }

    public function create(User $user, array $data)
    {
        try {
            if (isset($data['phone_numbers']) && is_array($data['phone_numbers'])) {
                
                //reset phone numbers
                if($user->phoneNumbers->isNotEmpty()){
                    $user->phoneNumbers()->delete();
                }
                
                // Add new phone numbers
                foreach ($data['phone_numbers'] as $phoneData) {

                    if ($phoneData['type'] === 'login') {
                        $user->update(['phone' => $phoneData['phone_number']]);
                        continue;
                    }

                    $user->phoneNumbers()->create([
                        'phone_type' => $phoneData['type'],
                        'phone' => $phoneData['phone_number'],
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error adding phone number: ' . $e->getMessage());
            $this->exception('Failed to add phone number. Please try again.');
        }

        return $user->refresh();
    }
}
