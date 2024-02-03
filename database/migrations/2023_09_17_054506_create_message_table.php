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
        Schema::create('message_table', function (Blueprint $table) {
            $table->id()->comment('Message id');
            $table->foreignId('room_id')->comment('Room id');
            $table->string('user_id', 255)->comment('User id');
            $table->string('user_name', 255)->comment('User name');
            $table->text('content')->nullable()->comment('Content');
            $table->string('file_path', 255)->nullable()->comment('File path');
            $table->string('icon_path', 255)->nullable()->comment('Icon path');
            $table->timestamp('read_at')->nullable()->comment('Read at');
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
        Schema::dropIfExists('message');
    }
};
