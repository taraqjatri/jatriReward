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
        Schema::create('log_events', function (Blueprint $table) {
            $table->id();
            $table->text('previous_data')->nullable(); //json
            $table->text('updated_data')->nullable(); //json
            $table->text('description')->nullable(); //json
            $table->text('action_by'); //json [user_type, user_id, user_name] , user_type=admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_events');
    }
};
