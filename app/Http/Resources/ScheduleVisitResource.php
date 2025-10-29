<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleVisitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'date' => $this->date_at,
            'time_in' => $this->time_in,
            'time_out' => $this->time_out,
            'verified_in' => $this->verified_in,
            'verified_out' => $this->verified_out,
            'reason' => $this->visitReason,
            'pay_rate' => $this->pay_rate,
            'type' => $this->type,
            'employee' => [
                'id' => $this->careWorker?->uuid,
                'first_name' => $this->careWorker?->first_name,
                'last_name' => $this->careWorker?->last_name,
                'full_name' => $this->careWorker?->full_name,
                'profile_picture' => $this->careWorker?->avatar,
            ],
            'client' => [
                'id' => $this->client?->uuid,
                'first_name' => $this->client?->first_name,
                'last_name' => $this->client?->last_name,
                'full_name' => $this->client?->full_name,
                'profile_picture' => $this->client?->avatar,
            ],
            'schedule' => [
                'id' => $this->schedule?->uuid,
                'schedule_id' => $this->schedule?->schedule_id,
            ],
            'status' => $this->getStatus($this),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function getStatus($visit): string
    {
        $status = 'scheduled';

        $visitDate = !empty($visit['date_at']) ? Carbon::parse($visit['date_at']) : null;

        $hasVerifiedIn  = !empty($visit['verified_in']);
        $hasVerifiedOut = !empty($visit['verified_out']);
        $hasScheduledIn = !empty($visit['time_in']);
        $hasScheduledOut = !empty($visit['time_out']);

        // Check if date has passed (end of the day)
        $isDatePassed = $visitDate && $visitDate->copy()->endOfDay()->lessThan(Carbon::now());

        if (($hasVerifiedIn && $hasVerifiedOut)) {
            if ($hasScheduledIn && $hasScheduledOut) {

                // Convert times to Carbon instances (anchored to a dummy date)
                $scheduledIn  = Carbon::parse('1970-01-01 ' . $visit['time_in']);
                $scheduledOut = Carbon::parse('1970-01-01 ' . $visit['time_out']);
                $verifiedIn   = Carbon::parse('1970-01-01 ' . $visit['verified_in']);
                $verifiedOut  = Carbon::parse('1970-01-01 ' . $visit['verified_out']);

                // Handle overnight (next-day) cases for verified times
                if ($verifiedOut->lessThan($verifiedIn)) {
                    $verifiedOut->addDay();
                }

                $scheduledDuration = $scheduledIn->diffInMinutes($scheduledOut, false);
                $verifiedDuration  = $verifiedIn->diffInMinutes($verifiedOut, false);

                // $isOverVerified =
                //     $verifiedDuration > $scheduledDuration ||
                //     $verifiedIn->lt($scheduledIn) ||
                //     $verifiedOut->gt($scheduledOut);

                $status = $verifiedDuration > $scheduledDuration ? 'over_verified' : 'verified';
            } else {
                $status = 'verified';
            }
        } elseif ($isDatePassed) {
            $status = 'past_due';
        }

        return $status;
    }
}
