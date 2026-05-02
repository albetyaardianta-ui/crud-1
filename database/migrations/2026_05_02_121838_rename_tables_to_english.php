<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::rename('produks', 'products');
    Schema::rename('kategoris', 'categories');

    Schema::table('products', function (Blueprint $table) {
        $table->renameColumn('nama', 'name');
        $table->renameColumn('harga_jual', 'price');
        $table->renameColumn('kategori_id', 'category_id');
    });

    Schema::table('categories', function (Blueprint $table) {
        $table->renameColumn('nama', 'name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('english', function (Blueprint $table) {
            //
        });
    }
};
