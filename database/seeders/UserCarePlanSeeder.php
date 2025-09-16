<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\UserCarePlan;
use App\Models\UserCarePlanCategory;
use App\Models\CarePlanCategory;
use App\Models\CarePlanItem;

class UserCarePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name',
                    Role::ROLE_PATIENT);
        })->get();
        // $carePlanCategory = CarePlanCategory::first();
        // $carePlanItems = CarePlanItem::where('category_id', $carePlanCategory->id)->get();

        foreach ($users as $user) {
            UserCarePlan::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'user_id'               => $user->id,
                // 'physician_name'        => 'Dr. John Doe',
                // 'physician_contact'     => '000-000-0000',
                // 'insurance_provider'    => 'Sample Insurance Co.',
                // 'policy_number'         => 'INS-123456789',
                // 'care_start_date'       => now(), 
                // 'preferred_wakeup_time' => "08:00 AM",
                // 'preferred_bed_time'    => "10:00 PM",
                // 'preferred_culture'     => "Western",
                // 'preferred_language'    => "English",
                // 'preferred_diet'        => "gluten-free",
                // 'preferred_activities'  => "Playing chess, reading books",
                // 'requests'              => "requires assistance with daily activities",
                // 'care_goals'            => "To improve mobility and independence",
                // 'date_reviewed'         => now(),
                // 'date_next_review'      => now()->addMonth(),
                // 'notes'                 => "This is a sample note for the care plan.",

                // 1. Summary
                'diagnosis' => 'Dementia, Arthritis',
                'allergies' => 'Peanuts',
                'mobility_level' => 'Wheelchair bound',
                'cognitive_level' => 'Forgetful',
                'communication_needs' => 'Hearing impairment',

                // 2. Environment & Safety
                'home_hazards' => 'Loose rugs, poor lighting',
                'fall_risk' => 'high',
                'emergency_contacts' => 'Son: John Doe, 555-1234',
                'emergency_plan' => 'Exit through kitchen, extinguisher near sink',
                'access_to_home' => 'Key',
                'equipment_in_home' => 'Wheelchair',
                'alarms_sensors' => 'Door Alarm',

                // 3. Personal Care & Hygiene
                'bathing' => 'Daily',
                'bathing_preference' => 'Shower chair, caregiver assist',
                'dressing' => 'AM',
                'dressing_preference' => 'Needs help with buttons',
                'grooming' => 'Daily',
                'grooming_preference' => 'Electric razor only',
                'oral_care' => 'AM',
                'oral_care_preference' => 'Dentures',
                'incontinence_care' => 'Yes',
                'incontinence_care_preference' => 'Adult diapers, change every 3 hours',
                'toileting_assistance' => 'Assist',
                'toileting_assistance_preference' => 'Bedside commode, prompted every 2 hours',

                // 4. Nutrition & Meal Support
                'meal_prep' => '3 meals',
                'meal_prep_preference' => 'No spicy food',
                'special_diet' => 'Low sodium',
                'special_diet_preference' => 'Doctor recommended for BP',
                'fluid_intake_monitoring' => 'Yes',
                'fluid_intake_monitoring_preference' => '8 cups/day',
                'feeding_assistance' => 'Yes',
                'feeding_assistance_preference' => 'Partial help, no liquids',
                'grocery_shopping' => 'Weekly',
                'grocery_shopping_preference' => 'Prefers organic brands',
                'snacks' => 'Provided',
                'snacks_preference' => 'Fruit only, no sugar',

                // 5. Laundry & Housekeeping
                'laundry' => 'Weekly',
                'laundry_preference' => 'Fold only, client assists',
                'light_housekeeping' => 'Weekly',
                'light_housekeeping_preference' => 'Kitchen and bathroom priority',
                'bed_lining_changes' => 'Weekly',
                'bed_lining_changes_preference' => 'Tuesdays preferred',
                'trash_removal' => 'Weekly',
                'trash_removal_preference' => 'Outdoor bin after dinner',
                'plant_pet_care' => 'Weekly',
                'plant_pet_care_preference' => 'Feeds cat at 6PM',

                // 6. Medication
                'medication_reminders' => 'AM',
                'medication_reminders_preference' => 'Pill box used, prefilled by nurse',
                'refill_reminders' => 'YES',
                'refill_reminders_preference' => 'Notify daughter via SMS',
                'medication_storage_check' => 'Weekly',
                'medication_storage_check_preference' => 'Check expiry dates and cool storage',

                // 7. Mobility & Exercise
                'transfer_assistance' => 'Stand-by',
                'transfer_assistance_preference' => 'Use gait belt for safety',
                'walking_range' => 'Daily',
                'walking_range_preference' => '5-minute walk in hallway',
                'outing' => 'Yes',
                'outing_preference' => 'Church every Sunday',

                // 8. Socialization & Mental Engagement
                'companionship' => 'Daily',
                'companionship_preference' => 'Talk about gardening, church',
                'game_puzzles' => 'Yes',
                'game_puzzles_preference' => 'Crossword puzzles after lunch',
                'reading_tv' => 'Daily',
                'reading_tv_preference' => 'Loves “The Price is Right” and Reader’s Digest',
                'community_involvement' => 'Yes',
                'community_involvement_preference' => 'Senior center bingo on Fridays',

                // 9. Care Coordination & Special Requests
                'daily_care_notes' => 'Must be completed after every shift',
                'incident_reporting' => 'Report all falls and behavioral issues',
                'family_communication' => 'Weekly',
                'scheduled_supervision_visit' => 'Supervisor to visit biweekly on Mondays',
                'special_requests' => 'Do not speak loudly, avoid discussing family issues',

                'created_by' => 1,
            ]);
        }

        // foreach ($carePlanItems as $item)
        // {
        //     UserCarePlanCategory::updateorCreate([
        //         'user_id' => $user->id,
        //         'user_care_plan_id' => $user_care_plan->id,
        //         'item_id' => $item->id,
        //     ], [
        //         'user_id' => $user->id,
        //         'user_care_plan_id' => $user_care_plan->id,
        //         'item_id' => $item->id,
        //     ]);
        // }
    }
}
