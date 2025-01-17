<div class="bg-gradient container mx-auto mt-12 space-y-4 max-w-6xl relative">
    <!-- Zdjęcie przepisu -->
    <div class="relative w-full  pb-[90%] overflow-hidden">
        <img class="absolute top-0 left-0 w-full h-full object-cover" src="{{ url('storage/' . $image) }}" alt="Zdjęcie przepisu">
    </div>

    <!-- Tytuł przepisu -->
    <div>
        <div class="text-center">
        <p class="text-xl font-bold text-orange-700">{{$title}}</p>
        @if (auth()->check())
        <form action="{{route('add.favorite',['id' => $id])}}" method="post">
            @csrf
            <button type="submit">
                <i class="fa-heart absolute text-3xl {{auth() -> user() -> hasFavorite($id) ? 'fa-solid' : 'fa-regular'}} text-red-600 top-2 right-0"></i>
            </button>
        </form>
        @else
        <button>
        <a href="{{route('login')}}">
            <i class="fa-heart absolute text-3xl fa-regular text-red-600 top-2 right-0"></i>
        </a>
        </button>
        @endif
        </div >
        <div class="text-white text-right">
        <i class="fa-regular fa-clock"></i>
        <span>{{$makeTime}} min</span>
        </div>
    </div>

    <!-- Składniki -->
    <div class="mt-2 px-2 ">
        <p class=" text-gray-100 font-extrabold">Kilka z użytych składników:</p>
        <p class="text-gray-400 font overflow-hidden max-w-full text-ellipsis whitespace-nowrap">
            @foreach($ingridients as $ingredient)
            {{$ingredient->name}}{{ !$loop->last ? ',' : '' }}
            @endforeach
        </p>
    </div>
    <div class="mt-2 px-2">
        <p class="text-gray-100 font-extrabold">Rodzaj kuchni:</p> 
        <p class="text-gray-400">{{$recipeCategory}}</p>
    </div>
    <div class="flex px-2 ">
        <div class="text-left w-1/2 text-gray-500"> <span>Ocena <br> {{$rating}}</span>
        </div>

        <!-- Autor przepisu -->
        <div class=" text-right w-1/2 text-gray-300">

            <span>Autor <br> {{$username}}</span>
        </div>
    </div>
    <div class="flex justify-center align-center flex-col">
        <a class="w-full" href={{route("recipes.show", ['recipe' => $id])}}>
            <x-primary-button class="w-full items-center text-center">{{__("Zobacz przepis")}}</x-primary-button>
        </a>
        @if (auth()->check())
        @if ($user_id === auth() -> user() ->id)
        <form class="w-full mt-1" action="{{route('recipes.showEdit',['id' => $id])}}" method="get">
            <x-secondary-button type="submit" class="w-full">{{__("Edytuj przepis")}}</x-secondary-button>
        </form>

        @else
        <form class="w-full mt-1" action="{{route('add.favorite',['id' => $id])}}" method="post">
            @csrf
            <x-secondary-button type="submit" class="w-full">{{__("Dodaj do ulubionych")}}</x-secondary-button>
        </form>
        @endif
        @endif
    </div>


</div>