<x-app-layout>
<div class ="flex items-center justify-center flex-col">    
<div>
        <p>Wszystkie przepisy</p>

    </div>

    @foreach ($recipes as $recipe)
    @php
    $title = $recipe['title'] ?? 'No Title';
    $username = $recipe['user_id'];
    $description = $recipe['description'] ?? 'No description available.';
    $ingredients = $recipe['ingredients'] ?? [];
    $imagePath = $recipe['image_path'] ?? 'No image available';
    @endphp
    <div class = "flex items-center justify-center w-1/2 h-1/4">
        <x-recipe-component :title="$title" :username="$username" :description="$description" :ingridients="$ingredients" :imagePath = $imagePath>
        </x-recipe-component>

        </div>
    @endforeach

    </div>
</x-app-layout>