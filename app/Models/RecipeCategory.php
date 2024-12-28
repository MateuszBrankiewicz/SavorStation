<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{
    protected $table = 'recipeCategory';
    protected $fillable = ['category'];
    public $timestamps = false;

    /**
     * Relacja one-to-many: RecipeCategory ma wiele przepisów.
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'category_id');
    }
}
