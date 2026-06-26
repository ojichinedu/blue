<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Sender
            $table->string('sender_name');
            $table->string('sender_email');
            $table->string('sender_phone');
            $table->text('sender_address');

            // Receiver
            $table->string('receiver_name');
            $table->string('receiver_email');
            $table->string('receiver_phone');
            $table->text('receiver_address');

            // Package
            $table->string('package_description')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('package_type', ['document', 'parcel', 'freight'])->default('parcel');

            // Status
            $table->enum('status', [
                'pending',
                'picked_up',
                'in_transit',
                'out_for_delivery',
                'delivered',
                'cancelled'
            ])->default('pending');

            // Coordinates
            $table->decimal('origin_lat', 10, 7)->nullable();
            $table->decimal('origin_lng', 10, 7)->nullable();
            $table->decimal('destination_lat', 10, 7)->nullable();
            $table->decimal('destination_lng', 10, 7)->nullable();
            $table->decimal('current_lat', 10, 7)->nullable();
            $table->decimal('current_lng', 10, 7)->nullable();

            // Delivery dates
            $table->timestamp('estimated_delivery')->nullable();
            $table->timestamp('actual_delivery')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
