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
    Schema::table('likes', function (Blueprint $table) {
        $table->dropForeign(['recipe_id']); // Usuń klucz obcy
        $table->dropColumn('recipe_id'); // Usuń kolumnę

        $table->foreignId('comment_id')->constrained('comments')->onDelete('cascade'); // Dodaj nową kolumnę z kluczem obcym
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
