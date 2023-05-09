<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_p_n_r_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('pnr', 100);
            $table->unsignedBigInteger('user_id');
            $table->string('user_name', 200)->nullable();
            $table->string('user_mobile', 20)->nullable();
            $table->string('product',30)->nullable();
            $table->string('from_stoppage',60)->nullable();
            $table->string('to_stoppage', 60)->nullable();
            $table->smallInteger('amount')->nullable();
            $table->smallInteger('serial')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('company_name', 100)->nullable();
            $table->string('vehicle_no', 60)->nullable();
            $table->timestamp('journey_date')->nullable();

            $table->unsignedBigInteger('seller_id')->nullable();
            $table->string('seller_name', 60)->nullable();
            $table->string('seller_mobile', 20)->nullable();
            $table->string('seller_type', 12)->nullable()->comment('COUNTER_MAN/CHECKER');

            $table->unsignedTinyInteger('user_point')->default(0);
            $table->unsignedTinyInteger('seller_point')->default(0);

            $table->string('status', 12)->nullable()->comment('INVALID/VALID');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->index('created_at_index');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_p_n_r_submissions');
    }
};
