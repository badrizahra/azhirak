<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetworkContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('network_contacts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('subject',250);
            $table->string('name',180)->nullable();
            $table->string('phone',250)->nullable();
            $table->string('email',130)->nullable();
            $table->boolean('is_seen');
            $table->text('description');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
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
        Schema::dropIfExists('network_contacts');
    }
}
