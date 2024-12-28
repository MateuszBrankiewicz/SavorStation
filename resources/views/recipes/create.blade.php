<x-app-layout>
    <div class="text-center mt-8">
        <h4 class="text-2xl font-bold text-gray-100">Dodaj Swój Własny Przepis</h4>
        <p class="text-gray-300 mt-2">Podziel się swoim przepisem z innymi! Wypełnij formularz poniżej.</p>
    </div>
    <div class="flex justify-center items-center mt-8">
        <div class="w-full max-w-4xl px-6 py-8 bg-gray-900 bg-opacity-50 rounded-lg shadow-lg border border-gray-800">
            <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Nazwa przepisu -->
                <div class="space-y-2">
                    <x-input-label for="recipeName" :value="__('Nazwa przepisu')" class="text-lg font-semibold text-gray-200"></x-input-label>
                    <x-text-input id="recipeName" name="recipeName" type="text" :value="old('recipeName')" class="w-full bg-gray-800 text-white rounded-md"></x-text-input>
                    @error('recipeName')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Opis przepisu -->
                <div class="space-y-2">
                    <x-input-label for="recipeDescription" :value="__('Opis przepisu')" class="text-lg font-semibold text-gray-200"></x-input-label>
                    <textarea id="recipeDescription" name="recipeDescription" rows="4" class="w-full p-3 bg-gray-800 text-white rounded-md border border-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-500">{{ old('recipeDescription') }}</textarea>
                    @error('recipeDescription')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Zdjęcie -->
                <div class="space-y-2">
                    <x-input-label for="recipeImage" :value="__('Zdjęcie przepisu')" class="text-lg font-semibold text-gray-200"></x-input-label>
                    <input id="recipeImage" name="recipeImage" type="file" class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-600 file:text-white hover:file:bg-indigo-700">
                    @error('recipeImage')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>
                <!-- Kategorie -->
                <div class="flex  justify-around">
                    <div>
                        <x-input-label for="categoryRec" :value="__('Kategoria przepisu')" class="text-lg font-semibold text-gray-200"></x-input-label>

                        <select name="categoryRec" id="categoryRec" class="bg-gray-800 text-gray-300">
                            <option value="0" {{ old('categoryRec') == '0' ? 'selected' : '' }}>-- Wybierz --</option>
                            <option value="1" {{ old('categoryRec') == '1' ? 'selected' : '' }}>Kuchnia włoska</option>
                            <option value="2" {{ old('categoryRec') == '2' ? 'selected' : '' }}>Kuchnia meksykańska</option>
                            <option value="3" {{ old('categoryRec') == '3' ? 'selected' : '' }}>Kuchnia polska</option>
                            <option value="4" {{ old('categoryRec') == '4' ? 'selected' : '' }}>Kuchnia chińska</option>
                            <option value="5" {{ old('categoryRec') == '5' ? 'selected' : '' }}>Kuchnia japońska</option>
                            <option value="6" {{ old('categoryRec') == '6' ? 'selected' : '' }}>Kuchnia indyjska</option>
                            <option value="7" {{ old('categoryRec') == '7' ? 'selected' : '' }}>Kuchnia francuska</option>
                            <option value="8" {{ old('categoryRec') == '8' ? 'selected' : '' }}>Kuchnia tajska</option>
                            <option value="9" {{ old('categoryRec') == '9' ? 'selected' : '' }}>Kuchnia amerykańska</option>
                            <option value="10" {{ old('categoryRec') == '10' ? 'selected' : '' }}>Kuchnia grecka</option>
                        </select>

                        @error('categoryRec')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-input-label :value="__('Czas wykonania')" class="text-lg font-semibold text-gray-200"></x-input-label>
                        <input type="number" name="makeTime" id="makeTime" class="bg-gray-800 text-gray-300" min="0" value="{{ old('makeTime') }}">
                        @error('makeTime')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>

                    <!-- Składniki -->
                    <div class="space-y-4">
                        <x-input-label :value="__('Składniki')" class="text-lg font-semibold text-gray-200"></x-input-label>
                        <div id="ingredientsContainer" class="space-y-3">
                            <div class="flex gap-4 ingredient-item">
                                <input type="text" name="ingredients[]" placeholder="Nazwa składnika" class="w-1/2 p-3 bg-gray-800 text-white rounded-md" value="{{ old('ingredients.0') }}">
                                @error('ingredients.0')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text" name="amounts[]" placeholder="Ilość" class="w-1/4 p-3 bg-gray-800 text-white rounded-md" value="{{ old('amounts.0') }}">
                                @error('amounts.0')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <select name="unity[]" class="w-1/4 p-3 bg-gray-800 text-white rounded-md">
                                    <option value="kg" {{ old('unity.0') == 'kg' ? 'selected' : '' }}>kg</option>
                                    <option value="ml" {{ old('unity.0') == 'ml' ? 'selected' : '' }}>ml</option>
                                    <option value="g" {{ old('unity.0') == 'g' ? 'selected' : '' }}>g</option>
                                    <option value="szt" {{ old('unity.0') == 'szt' ? 'selected' : '' }}>szt</option>
                                </select>
                            </div>
                        </div>
                        <button id="addIngredientButton" type="button" class="w-full bg-green-600 text-white rounded-md px-4 py-2 hover:bg-green-700">Dodaj składnik</button>
                    </div>

                    <!-- Kroki -->
                    <div class="space-y-4">
                        <x-input-label :value="__('Kroki')" class="text-lg font-semibold text-gray-200"></x-input-label>
                        <div id="stepsContainer" class="space-y-3">
                            <div class="flex gap-4 step-item">
                                <input type="text" name="steps[]" placeholder="Krok nr 1" class="w-full p-3 bg-gray-800 text-white rounded-md" value="{{ old('steps.0') }}">
                                @error('steps.0')
                                <p class="text-red-500 text-sm mt-1"> 'Kroki nie mogą być puste'</p>
                                @enderror
                            </div>
                        </div>
                        <button id="addStepButton" type="button" class="w-full bg-green-600 text-white rounded-md px-4 py-2 hover:bg-green-700">Dodaj krok</button>
                    </div>

                    <!-- Submit -->
                    <div>
                        <x-primary-button class="w-full py-3">
                            Dodaj Przepis
                        </x-primary-button>
                    </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    // Adding Ingredients
    document.getElementById('addIngredientButton').addEventListener('click', function() {
        const container = document.getElementById('ingredientsContainer');
        const ingredientDiv = document.createElement('div');
        ingredientDiv.classList.add('flex', 'gap-2', 'mb-2', 'ingredient-item');

        ingredientDiv.innerHTML = `
                <input type="text" name="ingredients[]" placeholder="Nazwa składnika" class="w-1/2 p-3 bg-gray-800 text-white rounded-md">
                <input type="text" name="amounts[]" placeholder="Ilość"     class="w-1/4 p-3 bg-gray-800 text-white rounded-md">
                <select name="unity[]" class="p-2 w-1/4 text-white bg-gray-800">
                    <option value="kg">kg</option>
                    <option value="ml">ml</option>
                    <option value="l">litry</option>
                    <option value="g">gramy</option>
                    <option value="lyz">lyzki</option>
                    <option value="szt">sztuki</option>
                    <option value="szkl">szklanki</option>
                </select>
 <button type="button" class="remove-item bg-red-600 text-white rounded-md px-3 py-2 hover:bg-red-700">
                                Usuń
                            </button>            `;

        container.appendChild(ingredientDiv);
    });

    // Adding Steps
    let stepCount = 2;
    document.getElementById('addStepButton').addEventListener('click', function() {
        const container = document.getElementById('stepsContainer');
        const stepDiv = document.createElement('div');
        stepDiv.classList.add('flex', 'gap-2', 'mb-2', 'step-item');

        stepDiv.innerHTML = `
                <input type="text" name="steps[]" placeholder="Krok nr ${stepCount}" class="w-full p-3 bg-gray-800 text-white rounded-md">
                 <button type="button" class="remove-item bg-red-600 text-white rounded-md px-3 py-2 hover:bg-red-700">
                                Usuń
                            </button>
            `;

        container.appendChild(stepDiv);
        stepCount++;
    });

    // Remove Items (Generic)
    document.addEventListener('click', function(e) {
        if (e.target && e.target.closest('.remove-item')) {
            const itemToRemove = e.target.closest('.ingredient-item, .step-item'); // Znajdź najbliższego rodzica z klasą
            if (itemToRemove) {
                itemToRemove.remove(); // Usuń cały element
            }
        }
    });
</script>