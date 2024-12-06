<div class="grid grid-cols-4 grid-rows-4 gap-4 text-orange-800 bg-gradient">
    <!-- Title Section -->
    <div class="col-span-2 col-start-2 text-2xl font-bold text-center">
        {{ $title ?? 'Untitled Recipe' }}
    </div>

    <!-- Image Section -->
    <div class="flex row-span-2 row-start-2 justify-center items-center">
        @if (!empty($image_path))
            <img src="{{ asset($image_path) }}" alt="{{ $title }}" class="max-w-full h-auto" />
        @else
            <span class="italic text-gray-500">No Image Available</span>
        @endif
    </div>

    <!-- Description Section -->
    <div class="col-span-3 row-start-2 p-4 text-lg text-left">
        {{ $description ?? 'No description available.' }}
    </div>

    <!-- Username Section -->
    <div class="col-span-3 col-start-2 row-start-3 font-medium text-right">
        Created by: {{ $username ?? 'Anonymous' }}
    </div>

    <!-- Ingredients Section -->
    <div class="col-span-2 col-start-3 row-start-4 p-4 border-t-2 border-gray-200">
        <h3 class="mb-2 font-semibold">Ingredients:</h3>
        <ul class="list-disc list-inside">
            @foreach ($ingridients ?? [] as $ingredient)
                <li>{{ $ingredient['name'] ?? 'Unknown Ingredient' }} - {{ $ingredient['amount'] ?? 'Unknown Amount' }}</li>
            @endforeach
        </ul>
    </div>
</div>
