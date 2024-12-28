<x-app-layout>
    <div class="text-center mb-6">
        <h4 class="text-2xl font-bold text-white">Edytuj przepis</h4>
    </div>
    <div class="flex justify-center items-center">
        <div class="w-full max-w-3xl px-6 py-8 bg-gray-900 bg-opacity-30 rounded-md border border-black backdrop-filter backdrop-blur-sm">
            <form method="POST" action="{{ route('recipes.update', $recipe->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Recipe Name -->
                <div class="mb-6">
                    <x-input-label for="recipeName" :value="__('Nazwa przepisu')" />
                    <x-text-input id="recipeName" name="recipeName" type="text" :value="old('recipeName', $recipe->title)" class="w-full" autofocus />
                    @error('recipeName')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recipe Description -->
                <div class="mb-6">
                    <x-input-label for="recipeDescription" :value="__('Opis przepisu')" />
                    <textarea id="recipeDescription" name="recipeDescription" rows="4" class="p-3 mt-2 w-full bg-gray-800 text-white rounded-md border-black shadow-sm focus:ring focus:ring-blue-500 focus:outline-none">{{ old('recipeDescription', $recipe->description) }}</textarea>
                    @error('recipeDescription')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ingredients -->
                <div id="ingredientsContainer" class="mb-6">
                    <x-input-label class="text-lg font-semibold text-gray-200" :value="__('Składniki')" />
                    @foreach($ingredients as $index => $ingredient)
                    <div class="flex gap-4 space-y-3 items-center" id="ingredient_{{ $index }}">
                        <input type="text" name="ingredients[]" placeholder="Nazwa składnika" class="w-1/2 p-3 bg-gray-800 text-white rounded-md" value="{{ old('ingredients.' . $index, $ingredient->name) }}" />
                        @error('ingredients.' . $index)
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <input type="text" name="amounts[]" placeholder="Ilość" class="w-1/4 p-3 bg-gray-800 text-white rounded-md" value="{{ old('amounts.' . $index, $ingredient->amount) }}" />
                        @error('amounts.' . $index)
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <select name="unity[]" class="w-1/4 p-3 bg-gray-800 text-white rounded-md">
                            <option value="kg" {{ old('unity.' . $index, $ingredient->unity) == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="ml" {{ old('unity.' . $index, $ingredient->unity) == 'ml' ? 'selected' : '' }}>ml</option>
                            <option value="l" {{ old('unity.' . $index, $ingredient->unity) == 'l' ? 'selected' : '' }}>litry</option>
                            <option value="g" {{ old('unity.' . $index, $ingredient->unity) == 'g' ? 'selected' : '' }}>gramy</option>
                            <option value="lyz" {{ old('unity.' . $index, $ingredient->unity) == 'lyz' ? 'selected' : '' }}>łyżki</option>
                            <option value="szt" {{ old('unity.' . $index, $ingredient->unity) == 'szt' ? 'selected' : '' }}>sztuki</option>
                            <option value="szkl" {{ old('unity.' . $index, $ingredient->unity) == 'szkl' ? 'selected' : '' }}>szklanki</option>
                        </select>
                        @error('unity.' . $index)
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <button type="button" class="bg-red-600 text-white rounded-md px-3 py-2 hover:bg-red-700" onclick="removeIngredient({{ $index }})">Usuń</button>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-end mb-6">
                    <button type="button" id="addIngredientButton" class="w-full bg-green-600 text-white rounded-md px-4 py-2 hover:bg-green-700">
                        Dodaj składnik
                    </button>
                </div>

                <!-- Recipe Image -->
                <div class="mb-6">
                    <x-input-label for="recipeImage" :value="__('Dodaj zdjęcie przepisu')" />
                    <input id="recipeImage" name="recipeImage" type="file"
                        class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 
                           file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600">
                    @error('recipeImage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex  justify-around">
                    <div>
                        <x-input-label for="categoryRec" :value="__('Kategoria przepisu')" class="text-lg font-semibold text-gray-200"></x-input-label>

                        <select name="categoryRec" id="categoryRec" class="bg-gray-800 text-gray-300">
                            <option value="0" {{ old('categoryRec',$recipe->category_id) == '0' ? 'selected' : '' }}>-- Wybierz --</option>
                            <option value="1" {{ old('categoryRec',$recipe->category_id) == '1' ? 'selected' : '' }}>Kuchnia włoska</option>
                            <option value="2" {{ old('categoryRec',$recipe->category_id) == '2' ? 'selected' : '' }}>Kuchnia meksykańska</option>
                            <option value="3" {{ old('categoryRec',$recipe->category_id) == '3' ? 'selected' : '' }}>Kuchnia polska</option>
                            <option value="4" {{ old('categoryRec',$recipe->category_id) == '4' ? 'selected' : '' }}>Kuchnia chińska</option>
                            <option value="5" {{ old('categoryRec',$recipe->category_id) == '5' ? 'selected' : '' }}>Kuchnia japońska</option>
                            <option value="6" {{ old('categoryRec',$recipe->category_id) == '6' ? 'selected' : '' }}>Kuchnia indyjska</option>
                            <option value="7" {{ old('categoryRec',$recipe->category_id) == '7' ? 'selected' : '' }}>Kuchnia francuska</option>
                            <option value="8" {{ old('categoryRec',$recipe->category_id) == '8' ? 'selected' : '' }}>Kuchnia tajska</option>
                            <option value="9" {{ old('categoryRec',$recipe->category_id) == '9' ? 'selected' : '' }}>Kuchnia amerykańska</option>
                            <option value="10" {{ old('categoryRec',$recipe->category_id) == '10' ? 'selected' : '' }}>Kuchnia grecka</option>
                        </select>

                        @error('categoryRec')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-input-label :value="__('Czas wykonania')" class="text-lg font-semibold text-gray-200"></x-input-label>
                        <input type="number" name="makeTime" id="makeTime" class="bg-gray-800 text-gray-300" min="0" value="{{old('makeTime',$recipe->make_time)}}">
                        @error('makeTime')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                <!-- Steps -->
                <div id="stepsContainer" class="mb-6">
                    <x-input-label :value="__('Kroki')" class="text-lg font-semibold text-gray-200" />
                    @foreach($recipe->instructions as $index => $step)
                    <div class="flex gap-2 mb-3 items-center space-y-3" id="step_{{ $index }}">
                        <input type="text" name="steps[]" placeholder="Krok nr {{ $index + 1 }}" class="w-full p-3 bg-gray-800 text-white rounded-md" value="{{ old('steps.' . $index, $step) }}" />
                        @error('steps.' . $index)
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <button type="button" class="bg-red-600 text-white rounded-md px-3 py-2 hover:bg-red-700" onclick="removeStep({{ $index }})">Usuń</button>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-end mb-6">
                    <button type="button" id="addStepButton" class="w-full bg-green-600 text-white rounded-md px-4 py-2 hover:bg-green-700">
                        Dodaj krok
                    </button>
                </div>

                <!-- Update Recipe Button -->
                <div class="flex justify-center">
                    <x-primary-button class="py-3 px-6">
                        Zaktualizuj przepis
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <script>
    let ingredientCount = {{ count($ingredients) }};
    let stepCount = {{ count($recipe->instructions) }};

    // Add Ingredient Functionality
    document.getElementById('addIngredientButton').addEventListener('click', function () {
        const container = document.getElementById('ingredientsContainer');
        const ingredientDiv = document.createElement('div');
        ingredientDiv.classList.add('flex', 'gap-4', 'items-center', 'mb-6');
        ingredientDiv.id = 'ingredient_' + ingredientCount;

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('bg-red-600', 'text-white', 'rounded-md', 'px-3', 'py-2', 'hover:bg-red-700');
        removeButton.innerHTML = 'Usuń';
        removeButton.addEventListener('click', function () {
            ingredientDiv.remove();
        });

        const ingredientInput = document.createElement('input');
        ingredientInput.type = 'text';
        ingredientInput.name = 'ingredients[]';
        ingredientInput.placeholder = 'Nazwa składnika';
        ingredientInput.classList.add('w-1/2', 'p-3', 'bg-gray-800', 'text-white', 'rounded-md');

        const quantityInput = document.createElement('input');
        quantityInput.type = 'text';
        quantityInput.name = 'amounts[]';
        quantityInput.placeholder = 'Ilość';
        quantityInput.classList.add('w-1/4', 'p-3', 'bg-gray-800', 'text-white', 'rounded-md');

        const unitySelect = document.createElement('select');
        unitySelect.name = 'unity[]';
        unitySelect.classList.add('w-1/4', 'p-3', 'bg-gray-800', 'text-white', 'rounded-md');
        ['kg', 'ml', 'l', 'g', 'lyz', 'szt', 'szkl'].forEach(function (unity) {
            const option = document.createElement('option');
            option.value = unity;
            option.textContent = unity;
            unitySelect.appendChild(option);
        });

        ingredientDiv.appendChild(ingredientInput);
        ingredientDiv.appendChild(quantityInput);
        ingredientDiv.appendChild(unitySelect);
        ingredientDiv.appendChild(removeButton);
        container.appendChild(ingredientDiv);

        ingredientCount++;
    });

    // Add Step Functionality
    document.getElementById('addStepButton').addEventListener('click', function () {
        const container = document.getElementById('stepsContainer');
        const stepDiv = document.createElement('div');
        stepDiv.classList.add('flex', 'gap-2', 'mb-3', 'items-center');
        stepDiv.id = 'step_' + stepCount;

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('bg-red-600', 'text-white', 'rounded-md', 'px-3', 'py-2', 'hover:bg-red-700');
        removeButton.innerHTML = 'Usuń';
        removeButton.addEventListener('click', function () {
            stepDiv.remove();
        });

        const stepInput = document.createElement('input');
        stepInput.type = 'text';
        stepInput.name = 'steps[]';
        stepInput.placeholder = 'Krok nr ' + (stepCount + 1);
        stepInput.classList.add('w-full', 'p-3', 'bg-gray-800', 'text-white', 'rounded-md');

        stepDiv.appendChild(stepInput);
        stepDiv.appendChild(removeButton);
        container.appendChild(stepDiv);

        stepCount++;
    });
</script>


</x-app-layout>