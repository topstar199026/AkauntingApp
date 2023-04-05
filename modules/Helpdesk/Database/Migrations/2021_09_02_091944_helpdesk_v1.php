<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HelpdeskV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpdesk_tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('subject', 80);
            $table->text('message');
            $table->integer('category_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('priority_id')->nullable();
            $table->integer('assignee_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('helpdesk_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('ticket_id');
            $table->text('message');
            $table->boolean('internal')->default(false);
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('helpdesk_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('name');
            $table->string('position');
            $table->string('flow_id');
            $table->string('flow');
            $table->string('color');
            $table->boolean('notification')->default(false);
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('helpdesk_priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('name');
            $table->integer('order');
            $table->boolean('default')->default(false);
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('company_id');
        });

        Schema::create('helpdesk_ticket_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('ticket_id')->nullable();
            $table->integer('document_id')->nullable();
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
        Schema::dropIfExists('helpdesk_tickets');
        Schema::dropIfExists('helpdesk_replies');
        Schema::dropIfExists('helpdesk_statuses');
        Schema::dropIfExists('helpdesk_priorities');
        Schema::dropIfExists('helpdesk_ticket_documents');
    }
}
