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
        if (!Schema::hasTable('access_log')) {
            Schema::create('access_log', function (Blueprint $table) {
                $table->id();
                $table->string('user');
                $table->string('action');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('access_log', function (Blueprint $table) {
            //
        });
    }
};
