<x-app-layout>
    
<div class="bg-gradient text-white p-3 rounded-lg shadow-lg">
    <center class="mb-6"><x-responsive-search-bar></x-responsive-search-bar></center>
    <p class="text-white font-bold text-2xl text-center mb-6">Filtruj przepisy</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kategorie -->
        <div class="flex flex-col">
            <label for="category" class="text-gray-200 mb-2">Wybierz kategorię:</label>
            <select name="category" id="category" class="bg-gray-800 text-gray-200 p-2 rounded-lg">
                <option value="0">-- Wybierz --</option>
                <option value="1">Kuchnia włoska</option>
                <option value="2">Kuchnia meksykańska</option>
                <option value="3">Kuchnia polska</option>
                <option value="4">Kuchnia chińska</option>
                <option value="5">Kuchnia japońska</option>
                <option value="6">Kuchnia indyjska</option>
                <option value="7">Kuchnia francuska</option>
                <option value="8">Kuchnia tajska</option>
                <option value="9">Kuchnia amerykańska</option>
                <option value="10">Kuchnia grecka</option>
            </select>
        </div>
        
        <!-- Czas przygotowania -->
        <div class="flex flex-col">
            <label for="makeTime" class="text-gray-200 mb-2">Czas przygotowania (min):</label>
            <input type="text" id="makeTime" name="makeTime" placeholder="np. 30" class="bg-gray-800 text-gray-200 p-2 rounded-lg">
        </div>
    </div>
    
    <div class="mt-6">
        <!-- Sortowanie -->
        <label for="sortingValue" class="text-gray-200 mb-2 block">Sortuj według:</label>
        <select name="sortingValue" id="sortingValue" class="bg-gray-800 text-gray-200 p-2 w-full rounded-lg">
            <option value="ratingDec">Oceny malejąco</option>
            <option value="ratingInc">Oceny rosnąco</option>
            <option value="timeDec">Czas przygotowania malejąco</option>
            <option value="timeInc">Czas przygotowania rosnąco</option>
            <option value="ratingCountDec">Liczba ocen malejąco</option>
            <option value="ratingCountInc">Liczba ocen rosnąco</option>
        </select>
    </div>
    
    <div class="mt-8 flex justify-end">
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
            Zastosuj filtry
        </button>
    </div>
</div>

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
        :categoryid="$recipe->category_id"
        :makeTime="$recipe->make_time"
        ></x-recipe-component>
        </div>
        @endforeach
    </div>
   <div class=" flex align-center justify-center "> {{$recipes->links('pagination::simple-tailwind')}}</div>
</x-app-layout>