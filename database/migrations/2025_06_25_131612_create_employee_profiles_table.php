<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            $table->string('manual_employee_id')->nullable();
            $table->tinyInteger('employee_status')->default(1);
            $table->string('social_security')->nullable();
            $table->date('hire_date')->nullable();
            $table->date('application_date')->nullable();
            $table->date('orientation_date')->nullable();
            $table->date('signed_job_description_date')->nullable();
            $table->date('signed_policy_procedure_date')->nullable();
            $table->date('evaluated_assigned_date')->nullable();
            $table->date('last_evaluation_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->tinyInteger('number_of_references')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_profiles');
    }
};
