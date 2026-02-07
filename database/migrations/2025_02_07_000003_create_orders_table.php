<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->string('status')->default('pending'); // pending, paid, processing, shipping, completed, cancelled, expired
            $table->bigInteger('total_price');
            $table->integer('shipping_cost');
            $table->string('courier_service')->nullable();
            $table->string('courier_name')->nullable();
            $table->string('snap_token')->nullable();
            $table->string('payment_channel')->nullable();
            $table->string('payment_ref')->nullable();
            $table->text('shipping_address');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
