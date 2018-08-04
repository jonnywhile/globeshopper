<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('from_user_id');
            $table->integer('to_globshopper_id');

            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('category_id');
            $table->integer('amount');

            $table->double('price_from')->nullable();
            $table->double('price_to')->nullable();

            $table->string('picture')->nullable();

            $table->string('status');
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
        Schema::dropIfExists('requests');
    }
}
