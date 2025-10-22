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
            'status' => $this->getStatus($this),
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
