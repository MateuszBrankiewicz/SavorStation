
<x-app-layout>
    <div class="flex flex-wrap  justify-center">
    @foreach ($recipes as $recipe)
  
        <div class = 'lg:w-[30%] sm:w-[80%] md:w-[48%] h-1/3 mx-1 my-2'>
    <x-recipe-component
        :title="$recipe->title"
        :username="$recipe->user_id"
        :description="$recipe->description"
        
        :image="$recipe->image_path"
        :ingridients="$recipe-> id"
        :rating="$recipe->rating"
        :id="$recipe->id"
        ></x-recipe-component>
        </div>
        @endforeach
    </div>
    <div class=" flex align-center justify-center "> {{$recipes->links('pagination::simple-tailwind')}}</div>

</x-app-layout>