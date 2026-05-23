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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subscriber_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mass_notification_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('notification_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('current_status_id')->constrained('notification_statuses')->cascadeOnDelete();
            
            $table->enum('channel', ['sms', 'email']);
            $table->text('message');
            $table->unsignedSmallInteger('retry_count')->default(0);
            $table->string('original_id')->nullable()->unique();

            $table->timestamps();

            $table->index('subscriber_id');
            $table->index('notification_type_id');
            $table->index('channel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
