<x-app-layout>
    <div class="text-center">
        <h4 class="text-white">Dodaj swój własny przepis</h4>
    </div>
    <div class = "flex justify-center items-center">
        <div
            class="flex justify-center items-center px-4 w-3/5 bg-gray-900 bg-opacity-30 rounded-md border border-black sm:px-6 md:w-2/4 lg:px-8 lg:w-2/5 xl:w-1/3 backdrop-filter backdrop-blur-sm">
            <form method="post" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Nazwa przepisu -->
                <div class="mb-4">
                    <x-input-label for="recipeName" :value="__('Nazwa przepisu')"></x-input-label>
                    <x-text-input id="recipeName" name="recipeName" type="text" :value="old('recipeName')"
                        class="w-full"></x-text-input>
                </div>

                <!-- Opis przepisu -->
                <div class="mb-4">
                    <x-input-label for="recipeDescription" :value="__('Opis przepisu')"></x-input-label>
                    <textarea id="recipeDescription" name="recipeDescription" rows="4"
                        class="p-2 mt-1 w-full bg-gray-900 rounded-md border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    {{ old('recipeDescription') }}
                </textarea>
                </div>

                <!-- Dynamiczne dodawanie składników -->
                <div id="ingredientsContainer" class="mb-4">
                    <x-input-label :value="__('Składniki')"></x-input-label>

                    <div class="flex gap-2 mb-2">
                        <input type="text" name="ingredients[]" placeholder="Nazwa składnika"
                            class="p-2 w-1/2 text-white bg-gray-800 rounded">
                        <input type="text" name="quantities[]" placeholder="Ilość"
                            class="p-2 w-1/2 text-white bg-gray-800 rounded">
                    </div>
                </div>

                <x-secondary-button type="button" id="addIngredientButton" class="py-2 px-4 text-white">
                    Dodaj składnik
                </x-secondary-button>

                <!-- Dodawanie zdjęcia przepisu -->
                <div class="mt-4 mb-4">
                    <x-input-label for="recipeImage" :value="__('Dodaj zdjęcie przepisu')"></x-input-label>
                    <input id="recipeImage" name="recipeImage" type="file"
                        class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600">
                </div>

                <!-- Przycisk dodawania przepisu -->
                <div class="mt-4">
                    <x-primary-button class="py-2 px-4">
                        Dodaj przepis
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('addIngredientButton').addEventListener('click', function() {
            const container = document.getElementById('ingredientsContainer');

            const ingredientDiv = document.createElement('div');
            ingredientDiv.classList.add('flex', 'gap-2', 'mb-2');

            const ingredientInput = document.createElement('input');
            ingredientInput.type = 'text';
            ingredientInput.name = 'ingredients[]';
            ingredientInput.placeholder = 'Nazwa składnika';
            ingredientInput.classList.add('w-1/2', 'p-2', 'bg-gray-800', 'text-white',
                'rounded');

            const quantityInput = document.createElement('input');
            quantityInput.type = 'text';
            quantityInput.name = 'quantities[]';
            quantityInput.placeholder = 'Ilość';
            quantityInput.classList.add('w-1/2', 'p-2', 'rounded', 'bg-gray-800', 'text-white');

            ingredientDiv.appendChild(ingredientInput);
            ingredientDiv.appendChild(quantityInput);
            container.appendChild(ingredientDiv);
        });
    </script>
</x-app-layout>