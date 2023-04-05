<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Appointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('appointment_name');
            $table->string('appointment_duration');
            $table->string('appointment_type');
            $table->double('amount', 15, 4)->nullable();
            $table->string('owner');
            $table->string('starting_time')->nullable();
            $table->string('ending_time')->nullable();
            $table->string('week_days')->nullable();
            $table->integer('before_schedule_appointment');
            $table->integer('after_schedule_appointment');
            $table->integer('allow_cancelled');
            $table->string('reminders');
            $table->string('recurring');
            $table->string('question_ids')->nullable();
            $table->boolean('enabled');
            $table->boolean('approval_control');

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('appointments_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('appointment_id');
            $table->integer('contact_id');
            $table->integer('employee_id');
            $table->string('week_days');
            $table->string('starting_time');
            $table->string('ending_time');

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('appointments_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('question');
            $table->string('question_type');
            $table->boolean('required_answer');
            $table->boolean('enabled');

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('appointments_questions_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('question_id');
            $table->string('avaible_answer');

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('appointments_scheduled', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('appointment_id');
            $table->integer('contact_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('document_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('question_answer')->nullable();
            $table->string('starting_time');
            $table->string('ending_time');
            $table->date('date');
            $table->string('status');

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments_appointments');
        Schema::dropIfExists('appointments_employees');
        Schema::dropIfExists('appointments_questions');
        Schema::dropIfExists('appointments_questions_values');
        Schema::dropIfExists('appointments_scheduled');
    }
}
