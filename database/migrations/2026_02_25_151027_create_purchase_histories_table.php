<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('email_id')
                  ->constrained('emails')
                  ->onDelete('cascade');

            $table->string('order_id', 100)->unique();
            $table->string('product_name', 100);
            $table->integer('amount');
            $table->string('payment_method', 30);
            $table->enum('payment_status', ['pending', 'success', 'failed']);
            $table->timestamp('purchased_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_histories');
    }
};