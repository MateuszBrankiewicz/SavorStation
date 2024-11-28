<x-app-layout>
    <div class="container mx-auto mt-12 space-y-12 max-w-6xl">
        <!-- Recipe Title -->
        <div class="flex flex-col justify-center items-center mx-auto w-max text-center bg-gradient">
            <div class='p-8'>
                <h1 class="text-5xl font-bold text-orange-400">{{ $recipe->title }}</h1>
                <p class="mt-4 text-lg italic text-gray-200">{{ $recipe->description }}</p>
            </div>


            <!-- Recipe Image -->

            <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="Recipe Image" class="w-full max-w-lg shadow-lg">
        </div>

        <!-- Ingredients and Instructions -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <!-- Ingredients Section -->
            <div class="p-6 rounded-lg shadow-lg bg-gradient">
                <h2 class="text-3xl font-semibold text-orange-400">Składniki</h2>
                @if ($combinedIngredients->isNotEmpty())
                    <ul class="mt-4 space-y-2">
                        @foreach ($combinedIngredients as $ingredient)
                            <li class="flex justify-between text-gray-300">
                                <span class="font-medium text-gray-200">{{ $ingredient['name'] }}</span>
                                <span class="text-white">
                                    {{ $ingredient['amount'] }} {{ $ingredient['unity'] }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 text-gray-400">Brak składników dla tego przepisu.</p>
                @endif
            </div>

            <!-- Instructions Section -->
            <div class="p-6 rounded-lg shadow-lg bg-gradient">
                <h2 class="text-3xl font-semibold text-orange-400">Instrukcje</h2>
                @if ($recipe->instructions && $recipe->instructions !== [])
                    <ol class="mt-4 space-y-3 list-decimal list-inside text-gray-300">
                        @foreach ($recipe->instructions as $instruction)
                            <li class="text-gray-200">{{ $instruction }}</li>
                        @endforeach
                    </ol>
                @else
                    <p class="mt-4 text-gray-400">Brak instrukcji dla tego przepisu.</p>
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        <div class="p-6 mb-2 rounded-lg shadow-lg bg-gradient">
            <h3 class="text-3xl font-bold text-center text-orange-400">Komentarze</h3>
            <div class="mt-6 space-y-4">
                @if (!empty($comments))
                    @foreach ($comments as $comment)
                        <x-comment :comment="$comment['comment']" :user="$comment['user']" />
                    @endforeach
                @else
                    <p class="text-center text-gray-400">Brak komentarzy do tego przepisu</p>
                @endif
            </div>
        </div>

        <!-- Back Link -->
        <div class="flex justify-center items-center">
            <a href="{{ route('recipes.index') }}"
                class="py-4 px-4 mb-4 text-lg font-semibold text-orange-400 rounded-lg shadow-md transition hover:text-orange-300 hover:bg-gray-700 bg-gradient">
                Powrót do listy przepisów
            </a>
        </div>
    </div>
</x-app-layout>
