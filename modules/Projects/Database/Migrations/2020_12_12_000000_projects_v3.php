<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('billing_type')->default(0);
            $table->double('billing_rate', 15, 4)->default(0);
        });
        
        Schema::rename('project_tasks', 'project_milestones');

        Schema::table('project_milestones', function (Blueprint $table) {
            $table->date('deadline_at')->nullable();
        });

        Schema::rename('project_sub_tasks', 'project_tasks');

        Schema::table('project_tasks', function (Blueprint $table) {
            $table->integer('task_id')->nullable()->change();
            $table->boolean('billable')->default(false);
            $table->boolean('is_invoiced')->default(false);
            $table->integer('invoice_id')->nullable();
            $table->boolean('is_visible_to_customer')->default(false);
            $table->double('hourly_rate', 15, 4)->default(0);
            $table->date('started_at')->nullable();
            $table->dropColumn('order_number');
        });

        Schema::table('project_tasks', function (Blueprint $table) {
            $table->renameColumn('task_id', 'milestone_id');
        });

        Schema::rename('project_subtask_users', 'project_task_users');

        Schema::table('project_task_users', function (Blueprint $table) {
            $table->integer('task_id')->nullable()->change();
        });
        
        Schema::table('project_task_users', function (Blueprint $table) {
            $table->renameColumn('task_id', 'milestone_id');
        });
        
        Schema::table('project_task_users', function (Blueprint $table) {
            $table->renameColumn('subtask_id', 'task_id');
        });

        Schema::create('project_task_timesheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('project_id');
            $table->integer('task_id');
            $table->integer('user_id');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->default(null)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_task_timesheets');
        Schema::dropIfExists('project_task_users');
        Schema::dropIfExists('project_tasks');
        Schema::dropIfExists('project_milestones');
    }
};
