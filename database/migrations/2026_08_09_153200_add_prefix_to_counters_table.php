<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('counters', function (Blueprint $table) {
            $table->string('prefix', 10)->nullable()->after('type');
        });

        // Set default prefixes for existing counters (Poli Umum -> A, Poli Gigi -> B, etc)
        $counters = DB::table('counters')->orderBy('id')->get();
        $prefixChar = 'A';
        foreach ($counters as $counter) {
            DB::table('counters')
                ->where('id', $counter->id)
                ->update(['prefix' => $prefixChar]);
            $prefixChar++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counters', function (Blueprint $table) {
            $table->dropColumn('prefix');
        });
    }
};
