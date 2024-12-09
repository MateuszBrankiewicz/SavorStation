<a href={{route("recipes.show", ['recipe' => $id])}}>
<div class="bg-gradient container mx-auto mt-12 space-y-4 max-w-6xl relative">
    <!-- Zdjęcie przepisu -->
    <img class="w-full h-auto" src="{{ url('storage/' . $image) }}" alt="Zdjęcie przepisu">
    
    <!-- Tytuł przepisu -->
    <div class="text-center">
        <p class="text-xl font-bold text-orange-700">{{$title}}</p>
    </div>
    
    <!-- Składniki -->
    <div class="mt-2 px-2 ">
        <p class=" text-gray-100 font-extrabold">Kilka z użytych składników:</p>
        <p class="text-gray-400 font">
        @foreach($ingridients as $ingredient)
            {{$ingredient->name}}{{ !$loop->last ? ',' : '' }}
        @endforeach
        </p>
    </div>
    <div class="flex px-2 ">
    <div class="text-left w-1/2 text-gray-500">    <span>Ocena <br> {{$rating}}</span>
    </div>

    <!-- Autor przepisu -->
    <div class=" text-right w-1/2 text-gray-300">
       
        <span>Autor <br> {{$username}}</span>
    </div>
    </div>
</div>
</a>