<x-app-layout>
<style>
    .rate label:nth-child(odd):before {
        content: "\f089"; /* FontAwesome half-star */
        font-family: "FontAwesome";
    }
    .rate label:nth-child(even):before {
        content: "\f005"; /* FontAwesome full-star */
        font-family: "FontAwesome";
    }
</style>
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
        <div class="flex flex-col justify-center text-center text-2xl align-center pb-4">
            <p class="text-orange-500">Ocen ten przepis</p>
      <x-rating-component :recipe="$recipe"></x-recipe-component>
      </div>
</div>



      <!-- Comments Section -->
      <center>   <div class="p-6 mb-2 w-1/2 rounded-lg shadow-lg bg-gradient">
            <h3 class="text-3xl font-bold text-center text-orange-400">Komentarze</h3>
            <div class="mt-6 space-y-4 flex flex-col">
                @if (!empty($comments))
                    @foreach ($comments as $comment)
                        <x-comment :comment="$comment['comment']" :user="$comment['user']" />
                    @endforeach
                @else
                    <p class="text-center text-gray-400">Brak komentarzy do tego przepisu</p>
                @endif
                <form action="{{route('comment.add',['recipe' => $recipe->id])}}" method="post" class="text-left text-gray-300">
                    @csrf
                    <span>Komentujesz jako {{Auth::user()->name}}</span>
                    <textarea name="content" id="content" class="bg-gradient w-5/6 text-white" ></textarea>
                    <x-primary-button>{{_("Dodaj komentarz")}}</x-primary-button>
                </form>
            </div>
        </div></center>

        <!-- Back Link -->
        <div class="flex justify-center items-center">
            <a href="{{ route('recipes.index') }}"
                class="py-4 px-4 mb-4 text-lg font-semibold text-orange-400 rounded-lg shadow-md transition hover:text-orange-300 hover:bg-gray-700 bg-gradient">
                Powrót do listy przepisów
            </a>
        </div>
    </div>
</x-app-layout>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ratingContainer = document.querySelector('#raiting-container');

    if (ratingContainer) {
        const stars = ratingContainer.querySelectorAll('.rating-star');
        const ratingText = document.createElement('span');
        ratingText.classList.add('ml-2', 'text-gray-300');
        ratingContainer.insertBefore(ratingText, stars[0]);

        let currentRating = parseFloat(ratingContainer.dataset.rating);

        // Function to update rating text
        function updateRatingText(rating) {
            ratingText.textContent = `(${rating.toFixed(1)} / 5)`;
        }

        // Initialize rating display
        updateRatingText(currentRating);

        // Highlight stars based on rating
        function highlightStars(stars, rating) {
            stars.forEach(star => {
                const starValue = parseFloat(star.getAttribute('data-value'));

                if (starValue <= rating) {
                    star.classList.remove('text-gray-500');
                    star.classList.add('text-yellow-500');
                } else {
                    star.classList.add('text-gray-500');
                    star.classList.remove('text-yellow-500');
                }
            });
        }

        // Initial star highlighting
        highlightStars(stars, currentRating);

        stars.forEach(star => {
            // Hover effect
            star.addEventListener('mouseover', () => {
                const hoverRating = parseFloat(star.getAttribute('data-value'));
                highlightStars(stars, hoverRating);
                updateRatingText(hoverRating);
            });

            // Mouseout - return to current rating
            star.addEventListener('mouseout', () => {
                highlightStars(stars, currentRating);
                updateRatingText(currentRating);
            });

            // Click to set rating
            star.addEventListener('click', () => {
                currentRating = parseFloat(star.getAttribute('data-value'));
                highlightStars(stars, currentRating);
                updateRatingText(currentRating);

                // Send rating to server
                fetch('{{ route("recipes.rate", $recipe->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ rating: currentRating })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Optional: Show success message
                        const successMessage = document.createElement('div');
                        successMessage.textContent = 'Ocena została zapisana!';
                        successMessage.classList.add('text-green-500', 'mt-2');
                        ratingContainer.appendChild(successMessage);
                        
                        // Remove success message after 3 seconds
                        setTimeout(() => {
                            successMessage.remove();
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Optional: Show error message
                    const errorMessage = document.createElement('div');
                    errorMessage.textContent = 'Nie udało się zapisać oceny. Spróbuj ponownie.';
                    errorMessage.classList.add('text-red-500', 'mt-2');
                    ratingContainer.appendChild(errorMessage);
                });
            });
        });
    }
});

</script>