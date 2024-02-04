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
        Schema::create('room_list_table', function (Blueprint $table) {
            $table->foreignId('room_id')->comment('Room id');
            $table->string('user_id', 255)->comment('User id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable()->comment('Delete Date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_list');
    }
};
