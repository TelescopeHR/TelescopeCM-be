<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarePlanItem;

class CarePlanItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarePlanItem::truncate();

        CarePlanItem::updateOrCreate(['category_id' => 1, 'name' => __('Bathing Assistance')]);
        CarePlanItem::updateOrCreate(['category_id' => 1, 'name' => __('Dressing Assistance')]);
        CarePlanItem::updateOrCreate(['category_id' => 1, 'name' => __('Grooming & Hygiene')]);
        CarePlanItem::updateOrCreate(['category_id' => 1, 'name' => __('Incontinence Care')]);
        CarePlanItem::updateOrCreate(['category_id' => 1, 'name' => __('Skin Care')]);
        CarePlanItem::updateOrCreate(['category_id' => 1, 'name' => __('Mobility Assistance')]);
        CarePlanItem::updateOrCreate(['category_id' => 1, 'name' => __('Medication Reminders')]);

        CarePlanItem::updateOrCreate(['category_id' => 2, 'name' => __('Emotional Support')]);
        CarePlanItem::updateOrCreate(['category_id' => 2, 'name' => __('Engaging in Hobbies & Activities')]);
        CarePlanItem::updateOrCreate(['category_id' => 2, 'name' => __('Accompaniment to Appointments')]);
        CarePlanItem::updateOrCreate(['category_id' => 2, 'name' => __('Social Interaction & Conversation')]);
        CarePlanItem::updateOrCreate(['category_id' => 2, 'name' => __('Assistance with Communication (phone, video calls, etc.)')]);

        CarePlanItem::updateOrCreate(['category_id' => 3, 'name' => __('Light Housekeeping')]);
        CarePlanItem::updateOrCreate(['category_id' => 3, 'name' => __('Laundry')]);
        CarePlanItem::updateOrCreate(['category_id' => 3, 'name' => __('Meal Preparation & Special Diet Assistance')]);
        CarePlanItem::updateOrCreate(['category_id' => 3, 'name' => __('Grocery Shopping')]);
        CarePlanItem::updateOrCreate(['category_id' => 3, 'name' => __('Pet Care')]);

        CarePlanItem::updateOrCreate(['category_id' => 4, 'name' => __('Fall Prevention')]);
        CarePlanItem::updateOrCreate(['category_id' => 4, 'name' => __('Wandering Prevention')]);
        CarePlanItem::updateOrCreate(['category_id' => 4, 'name' => __('Emergency Response System Use')]);
        CarePlanItem::updateOrCreate(['category_id' => 4, 'name' => __('Home Safety Checks')]);

        CarePlanItem::updateOrCreate(['category_id' => 5, 'name' => __('Medication Management')]);
        CarePlanItem::updateOrCreate(['category_id' => 5, 'name' => __('Diabetes Monitoring')]);
        CarePlanItem::updateOrCreate(['category_id' => 5, 'name' => __('Dementia/Alzheimer’s Support')]);
        CarePlanItem::updateOrCreate(['category_id' => 5, 'name' => __('Post-Surgical Care')]);
        CarePlanItem::updateOrCreate(['category_id' => 5, 'name' => __('Oxygen Therapy Assistance')]);
    }
}
