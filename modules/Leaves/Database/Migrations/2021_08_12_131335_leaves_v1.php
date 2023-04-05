<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeavesV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('leave_type_id');
            $table->foreignId('year_id');
            $table->foreignId('position_id')->nullable();
            $table->string('name');
            $table->string('contract_type')->nullable();
            $table->string('gender')->nullable();
            $table->integer('days');
            $table->integer('applicable_after');
            $table->integer('carryover_days')->default(0);
            $table->boolean('is_paid')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
            $table->index('leave_type_id');
            $table->index('year_id');
            $table->index('position_id');
        });

        Schema::create('leaves_leave_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->string('name');
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('leaves_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('leaves_entitlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('policy_id');
            $table->foreignId('employee_id');

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
            $table->index('policy_id');
            $table->index('employee_id');
        });

        Schema::create('leaves_allowances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('entitlement_id');
            $table->foreignId('employee_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('type');
            $table->integer('days');

            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
            $table->index('entitlement_id');
            $table->index('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves_policies');
        Schema::dropIfExists('leaves_leave_types');
        Schema::dropIfExists('leaves_years');
        Schema::dropIfExists('leaves_entitlements');
    }
}
