<x-app-layout>
    <div class="mx-auto mt-12 max-w-4xl">
        <!-- Recipe Title and Description -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-white">{{ $recipe->title }}</h1>
        </div>
        <!-- Recipe Image -->
        <div class="flex justify-center items-center direction-column">
            <div
                class="px-4 w-3/5 bg-gray-900 bg-opacity-30 rounded-md border border-black backdrop-filter backdrop-blur-sm">

                <p class="mt-4 text-lg text-gray-300">{{ $recipe->description }}</p>
                @if ($recipe->image_path)
                    <div class="flex justify-center mb-8">
                        <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="Recipe Image"
                            class="w-full max-w-md rounded-lg shadow-md">
                    </div>
                @endif

                <!-- Ingredients Section -->
                <div class="p-6 mb-8 bg-gray-800 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold text-indigo-400">Składniki</h2>
                    @if ($combinedIngredients->isNotEmpty())
                        <ul class="mt-4 space-y-3">
                            @foreach ($combinedIngredients as $ingredient)
                                <li class="text-gray-300">
                                    <span class="font-semibold">{{ $ingredient['name'] }}</span>
                                    - <span class="font-semibold text-white">{{ $ingredient['amount'] }}</span>
                                    <span class="text-gray-400 uppercase">{{ $ingredient['unity'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mt-4 text-gray-500">Brak składników dla tego przepisu.</p>
                    @endif
                </div>

                <!-- Instructions Section -->
                <div class="p-6 mb-8 bg-gray-800 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold text-indigo-400">Instrukcje</h2>
                    @if ($recipe->instructions && $recipe->instructions !== [])
                        <ol class="mt-4 space-y-3 list-decimal list-inside text-gray-300">
                            @foreach ($recipe->instructions as $instruction)
                                <li>{{ $instruction }}</li>
                            @endforeach
                        </ol>
                    @else
                        <p class="mt-4 text-gray-500">Brak instrukcji dla tego przepisu.</p>
                    @endif
                </div>
            </div>
        </div>
        <!-- Back Link -->
        <div class="text-center">
            <a href="{{ route('recipes.index') }}"
                class="py-2 px-4 text-sm font-semibold text-indigo-500 bg-gray-700 rounded-lg transition hover:text-indigo-700 hover:bg-gray-600">
                Powrót do listy przepisów
            </a>
        </div>
    </div>
    {{ $recipe }}
</x-app-layout>
