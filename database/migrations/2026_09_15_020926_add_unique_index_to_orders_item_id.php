<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * An item can be sold only once, which the Item::order() HasOne relation
     * already assumes. Enforce it in the database so concurrent checkouts
     * cannot both create an order for the same item.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unique('item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Once the unique index exists MySQL uses it to back the foreign
            // key and drops the redundant one, so the constraint has to be
            // released before the index can be removed and then restored.
            $table->dropForeign(['item_id']);
            $table->dropUnique(['item_id']);
            $table->foreign('item_id')->references('id')->on('items')->cascadeOnDelete();
        });
    }
};
