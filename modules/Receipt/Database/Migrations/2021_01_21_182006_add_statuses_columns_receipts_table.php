<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusesColumnsReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->string('statuses')->default(trans('documents.statuses.pending'));
            $table->string('currency_code')->nullable();
            $table->longText('image')->nullable()->change();
            $table->integer('category_id')->nullable()->change();
            $table->string('file_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('statuses');
        });
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('currency_code');
        });
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('file_name');
        });
    }
}
