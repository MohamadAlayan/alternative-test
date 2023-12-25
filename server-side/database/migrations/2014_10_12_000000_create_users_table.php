<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->index();
            $table->string('email_verify_code', 8)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_dialing_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone_verify_code', 8)->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('type')->default(\App\Enums\UserType::USER->value);
            $table->tinyInteger('status')->default(\App\Enums\UserStatus::ACTIVE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
