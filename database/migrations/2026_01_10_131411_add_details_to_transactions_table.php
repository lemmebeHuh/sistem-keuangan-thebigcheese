<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_add_details_to_transactions_table.php
public function up(): void
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->integer('quantity')->default(1)->after('category_id');
        $table->decimal('price_per_unit', 15, 2)->default(0)->after('quantity');
    });
}

public function down(): void
{
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn(['quantity', 'price_per_unit']);
    });
}
};
