<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->date('date');
            $table->date('create_date');
            $table->string('merchant');
            $table->double('total_amount');
            $table->double('tax_amount');
            $table->integer('category_id');
            $table->integer('payment_id')->nullable();
            $table->string('payment_method');
            $table->string('image');

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
        Schema::dropIfExists('receipts');
    }
}
