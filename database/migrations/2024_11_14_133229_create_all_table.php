<?
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabela recipes
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('instructions');
            $table->string('imagePath')->nullable();
            $table->timestamps();
        });

        // Tabela ingredients
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Tabela recipe_ingredients (pivot table)
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained('ingredients')->onDelete('cascade');
            $table->string('amount');
            $table-> timestamps();
        });

        // Tabela comments
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        // Tabela favorites
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('recipe_id')->constrained('recipes')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabela search_queries
        Schema::create('search_queries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('recipes_id')->constrained('recipes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Usuwanie tabel w odwrotnej kolejności ze względu na klucze obce
        Schema::dropIfExists('search_queries');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('recipe_ingredients');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('recipes');
    }
};
