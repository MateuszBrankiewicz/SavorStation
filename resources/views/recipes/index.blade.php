<x-app-layout>
    <div class="flex flex-wrap  justify-center">
    @foreach ($recipes as $recipe)
    @php
   
            $directIngredients = DB::table('ingredients')
                ->join('recipe_ingredients', 'ingredients.id', '=', 'recipe_ingredients.ingredient_id')
                ->where('recipe_ingredients.recipe_id', $recipe->id)
                ->select('ingredients.*', 'recipe_ingredients.amount', 'recipe_ingredients.unity')
                ->get();
                $directIngredients = $directIngredients -> toArray();
                //error_log(print_r($recipe['ingredients']->toArray(), true));

        @endphp
        <div class = 'lg:w-[30%] sm:w-[80%] md:w-[48%] h-1/3 mx-1 my-2'>
    <x-recipe-component
        :title="$recipe->title"
        :username="$recipe->user_id"
        :description="$recipe->description"
        
        :image="$recipe->image_path"
        :ingridients="$directIngredients"
        :rating="$recipe->rating"
        :id="$recipe->id"
        ></x-recipe-component>
        </div>
        @endforeach
    </div>
   <div class=" flex align-center justify-center "> {{$recipes->links('pagination::simple-tailwind')}}</div>
</x-app-layout>