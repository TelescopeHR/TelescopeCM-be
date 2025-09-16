<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_care_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            // $table->string('physician_name')->nullable()->default(null);
            // $table->string('physician_contact')->nullable()->default(null);
            // $table->string('insurance_provider')->nullable()->default(null);
            // $table->string('policy_number')->nullable()->default(null);
            // $table->dateTime('care_start_date')->nullable()->default(null);
            // $table->string('preferred_wakeup_time')->nullable()->default(null);
            // $table->string('preferred_bed_time')->nullable()->default(null);
            // $table->string('preferred_culture')->nullable()->default(null);
            // $table->string('preferred_language')->nullable()->default(null);
            // $table->text('preferred_diet')->nullable()->default(null);
            // $table->text('preferred_activities')->nullable()->default(null);
            // $table->text('requests')->nullable()->default(null);
            // $table->text('care_goals')->nullable()->default(null);
            // $table->dateTime('date_reviewed')->nullable()->default(null);
            // $table->dateTime('date_next_review')->nullable()->default(null);
            // $table->text('notes')->nullable()->default(null);
            // $table->unsignedBigInteger('created_by')->nullable()->default(null);
            // $table->timestamps();

            //client overview or summary
            $table->string('diagnosis', 255)->nullable();
            $table->string('allergies', 255)->nullable();
            $table->string('mobility_level', 255)->nullable();
            $table->string('cognitive_level', 255)->nullable();
            $table->string('communication_needs', 255)->nullable();

            //care needs 
            $table->longText('care_needs')->nullable();

            //environment & safety
            $table->string('home_hazards', 255)->nullable();
            $table->string('fall_risk', 20)->nullable();
            $table->string('emergency_contacts', 255)->nullable();
            $table->string('emergency_plan', 255)->nullable();
            $table->string('access_to_home', 255)->nullable();
            $table->string('equipment_in_home', 255)->nullable(); 
            $table->string('alarms_sensors', 255)->nullable();

            // Personal Care & Hygiene
            $table->string('bathing', 25)->nullable(); 
            $table->string('bathing_preference', 255)->nullable();
            $table->string('dressing', 25)->nullable();
            $table->string('dressing_preference', 255)->nullable();
            $table->string('grooming', 25)->nullable();
            $table->string('grooming_preference', 255)->nullable();
            $table->string('oral_care', 25)->nullable();
            $table->string('oral_care_preference', 255)->nullable();
            $table->string('incontinence_care', 255)->nullable();
            $table->string('incontinence_care_preference', 255)->nullable();
            $table->string('toileting_assistance', 255)->nullable();
            $table->string('toileting_assistance_preference', 255)->nullable();

            //Nutrition & Meal Support
            $table->string('meal_prep', 25)->nullable();
            $table->string('meal_prep_preference', 255)->nullable();
            $table->string('special_diet', 25)->nullable();
            $table->string('special_diet_preference', 255)->nullable();
            $table->string('fluid_intake_monitoring', 25)->nullable();
            $table->string('fluid_intake_monitoring_preference', 255)->nullable();
            $table->string('feeding_assistance', 25)->nullable(); 
            $table->string('feeding_assistance_preference', 255)->nullable();
            $table->string('grocery_shopping', 25)->nullable();
            $table->string('grocery_shopping_preference', 255)->nullable();
            $table->string('snacks', 25)->nullable();
            $table->string('snacks_preference', 255)->nullable();

            //Household Support
            $table->string('laundry', 25)->nullable();
            $table->string('laundry_preference', 255)->nullable();
            $table->string('light_housekeeping', 25)->nullable();
            $table->string('light_housekeeping_preference', 255)->nullable();
            $table->string('bed_lining_changes', 25)->nullable();
            $table->string('bed_lining_changes_preference', 255)->nullable();
            $table->string('trash_removal', 25)->nullable();
            $table->string('trash_removal_preference', 255)->nullable();
            $table->string('plant_pet_care', 25)->nullable();
            $table->string('plant_pet_care_preference', 255)->nullable();

            //Medication Reminders (Non-Administration)
            $table->string('medication_reminders', 25)->nullable();       
            $table->string('medication_reminders_preference', 255)->nullable();
            $table->string('refill_reminders', 25)->nullable();
            $table->string('refill_reminders_preference', 255)->nullable();
            $table->string('medication_storage_check', 25);
            $table->string('medication_storage_check_preference', 255)->nullable();

            //Mobility & Exercise
            $table->string('transfer_assistance', 25)->nullable();
            $table->string('transfer_assistance_preference', 255)->nullable();
            $table->string('walking_range', 25)->nullable();
            $table->string('walking_range_preference', 255)->nullable();
            $table->string('outing', 25)->nullable();
            $table->string('outing_preference', 255)->nullable();

            //Socialization & Mental Engagement
            $table->string('companionship', 25)->nullable();
            $table->string('companionship_preference', 255)->nullable();
            $table->string('game_puzzles', 25)->nullable();
            $table->string('game_puzzles_preference', 255)->nullable();
            $table->string('reading_tv', 25)->nullable();
            $table->string('reading_tv_preference', 255)->nullable();
            $table->string('community_involvement', 25)->nullable();
            $table->string('community_involvement_preference', 255)->nullable();

            //Care Coordination & Documentation
            $table->longText('daily_care_notes')->nullable();
            $table->longText('incident_reporting')->nullable();
            $table->string('family_communication', 25)->nullable();
            $table->longText('scheduled_supervision_visit')->nullable();

            //Special Requests / Preferences
            $table->longText('special_requests', 255)->nullable();

            $table->foreignId('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Then drop the table
        Schema::dropIfExists('user_care_plans');
    }
};
