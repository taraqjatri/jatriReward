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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('phone',20)->unique();
            $table->string('email',45)->unique();
            $table->string('password',255);
            $table->string('designation',50);
            $table->string('avatar')->nullable();
            $table->boolean('status')->default(true);
            $table->text('roles')->nullable();
            $table->string('admin_type', 20)->default('REGULAR');
            $table->unsignedInteger('line_manager_id')->nullable();
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
        Schema::dropIfExists('admins');
    }
};
