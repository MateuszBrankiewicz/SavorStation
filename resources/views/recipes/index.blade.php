<x-app-layout>

@if(session('success'))
    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Sukces!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <button 
            onclick="document.getElementById('success-alert').style.display='none'" 
            class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-500 hover:text-green-800">
            <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Zamknij</title>
                <path d="M14.348 14.849a1 1 0 01-1.414 0L10 11.414l-2.934 2.935a1 1 0 11-1.414-1.414l2.935-2.934-2.935-2.934a1 1 0 011.414-1.414L10 8.586l2.934-2.935a1 1 0 111.414 1.414L11.414 10l2.935 2.934a1 1 0 010 1.415z"/>
            </svg>
        </button>
    </div>
    @endif
@if (session('error'))
<div id="success-alert" class="bg-green-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Błąd</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <button 
            onclick="document.getElementById('success-alert').style.display='none'" 
            class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-500 hover:text-red-800">
            <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Zamknij</title>
                <path d="M14.348 14.849a1 1 0 01-1.414 0L10 11.414l-2.934 2.935a1 1 0 11-1.414-1.414l2.935-2.934-2.935-2.934a1 1 0 011.414-1.414L10 8.586l2.934-2.935a1 1 0 111.414 1.414L11.414 10l2.935 2.934a1 1 0 010 1.415z"/>
            </svg>
        </button>
    </div>
@endif

<div class="bg-gradient text-white p-3 rounded-lg shadow-lg">
<form action="{{route('recipes.search')}}" method="get">

<center class="mb-6">
        <x-responsive-search-bar></x-responsive-search-bar></center>
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
            <option value="0">-- Wybierz --</option>
            <option value="ratingDec">Oceny malejąco</option>
            <option value="ratingInc">Oceny rosnąco</option>
            <option value="timeDec">Czas przygotowania malejąco</option>
            <option value="timeInc">Czas przygotowania rosnąco</option>
            <option value="ratingCountDec">Liczba ocen malejąco</option>
            <option value="ratingCountInc">Liczba ocen rosnąco</option>
        </select>
    </div>
    
    <div class="mt-8 flex justify-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
            Zastosuj filtry
        </button>
    </div>
    </form>
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