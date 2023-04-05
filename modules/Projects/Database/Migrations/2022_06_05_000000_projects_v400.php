<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('status')->default('inprogress')->change();
            $table->string('billing_type')->after('ended_at')->change();
            $table->string('billing_rate')->after('billing_type')->change();
        });

        Schema::table('project_tasks', function (Blueprint $table) {
            $table->string('status')->change();
            $table->string('priority')->change();
        });

        Schema::table('project_discussions', function (Blueprint $table) {
            $table->renameColumn('name', 'subject');
        });

        Schema::table('project_discussions', function (Blueprint $table) {
            $table->dropColumn('total_comment');
        });

        Schema::table('project_discussions', function (Blueprint $table) {
            $table->dropColumn('total_like');
        });

        Schema::create('project_financials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('project_id');
            $table->morphs('financialable');
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
        // 
    }
};
