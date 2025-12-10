<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add nullable first (without unique)
            $table->string('product_code')->nullable()->after('id');
            $table->string('size')->nullable()->after('stock');
        });

        // Assign unique product codes to existing rows
        $products = DB::table('products')->get();
        foreach ($products as $index => $product) {
            DB::table('products')
                ->where('id', $product->id)
                ->update([
                    'product_code' => 'PRD-' . str_pad($product->id, 4, '0', STR_PAD_LEFT)
                ]);
        }

        // Now add unique constraint safely
        Schema::table('products', function (Blueprint $table) {
            $table->unique('product_code');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['product_code']);
            $table->dropColumn('product_code');
            $table->dropColumn('size');
        });
    }
};
