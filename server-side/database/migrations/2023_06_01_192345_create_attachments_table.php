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
        schema::create('attachment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->index();;
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });


        schema::create('attachments_types', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->index();;
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique()->index();;
            $table->string('filename');
            $table->string('file_hash');
            $table->string('file_path');
            $table->string('mime_type');
            $table->unsignedBigInteger('size');
            $table->string('extension');
            $table->foreignId('attachment_category_id')->nullable()->constrained('attachment_categories');
            $table->foreignId('attachment_type_id')->constrained('attachments_types');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->boolean('is_private')->default(true); // Set to true for private files
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['attachments', 'attachment_categories', 'attachments_types'];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
