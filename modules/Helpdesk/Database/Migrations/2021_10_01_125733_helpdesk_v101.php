<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HelpdeskV101 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('helpdesk_priorities', function (Blueprint $table) {
            $table->string('created_from', 100)->nullable()->after('default');
        });

        Schema::table('helpdesk_statuses', function (Blueprint $table) {
            $table->string('created_from', 100)->nullable()->after('notification');
        });

        Schema::table('helpdesk_tickets', function (Blueprint $table) {
            $table->string('created_from', 100)->nullable()->after('assignee_id');
        });

        Schema::table('helpdesk_replies', function (Blueprint $table) {
            $table->string('created_from', 100)->nullable()->after('internal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('helpdesk_priorities', function (Blueprint $table) {
            $table->dropColumn('created_from');
        });

        Schema::table('helpdesk_statuses', function (Blueprint $table) {
            $table->dropColumn('created_from');
        });

        Schema::table('helpdesk_tickets', function (Blueprint $table) {
            $table->dropColumn('created_from');
        });

        Schema::table('helpdesk_replies', function (Blueprint $table) {
            $table->dropColumn('created_from');
        });
    }
}
