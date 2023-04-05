<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProposalsV205 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->longText('content_html')->change();
            $table->longText('content_css')->change();
            $table->longText('content_components')->change();
            $table->longText('content_style')->change();
        });

        Schema::table('proposal_templates', function (Blueprint $table) {
            $table->longText('content_html')->change();
            $table->longText('content_css')->change();
            $table->longText('content_components')->change();
            $table->longText('content_style')->change();
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
}
