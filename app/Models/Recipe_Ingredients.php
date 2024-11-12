<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Recipe_Ingredients extends Model
{
    public function up ()
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->bigIncrements('recipe_id');
            $table->bigInteger('ingredients_id');
            $table->string('amount');

        });
    }
}
