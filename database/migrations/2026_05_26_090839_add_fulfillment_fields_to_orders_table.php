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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->nullable()->unique()->after('id');
            $table->string('fulfillment_method')->default('delivery')->after('status');
            $table->string('delivery_location')->nullable()->after('fulfillment_method');

            $table->index(['status', 'created_at']);
            $table->index(['fulfillment_method', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['fulfillment_method', 'created_at']);
            $table->dropUnique(['order_number']);
            $table->dropColumn(['order_number', 'fulfillment_method', 'delivery_location']);
        });
    }
};
