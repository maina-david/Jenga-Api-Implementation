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
        Schema::create('jenga_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_code');
            $table->longText('access_token');
            $table->longText('refresh_token');
            $table->dateTime('expires_in');
            $table->dateTime('issued_at');
            $table->string('token_type');
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
        Schema::dropIfExists('jenga_tokens');
    }
};
