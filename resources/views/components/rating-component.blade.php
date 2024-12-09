<div 
    x-data="{ hoverRating: 0, currentRating: {{ $recipe->rating ?? 0 }} }"
    x-on:mouseleave="hoverRating = 0"
    class="font-large flex align-center justify-center mb-2"
>
    @php
        $rateUrl = route('recipes.rate', ['recipe' => $recipe->id]);
    @endphp

    @for ($i = 0; $i < $maxStars; $i++)
        <span 
            x-on:click="
               fetch('{{ $rateUrl }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
    },
    body: JSON.stringify({ rating: {{ $i + 1 }} })
})
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.text();  // Return the raw response as text
})
.then(text => {
    console.log(text);  // Log the raw response
    try {
        const data = JSON.parse(text);  // Manually parse the response
        currentRating = data.newRating;
        hoverRating = 0;
    } catch (error) {
        console.error('Error parsing JSON:', error);
    }
})
.catch(error => {
    console.error('Error:', error);
});

            "
            x-on:mouseover="hoverRating = {{ $i + 1 }}"
            class="cursor-pointer"
        >
            <i 
                x-bind:class="{
                    'fas fa-star text-warning text-orange-300': (hoverRating > 0 ? hoverRating > {{ $i }} : currentRating > {{ $i }}),
                    'fas fa-star-half-alt text-orange-300 text-warning': (hoverRating === 0 && currentRating - {{ $i }} > 0 && currentRating - {{ $i }} < 1),
                    'far fa-star text-warning': (hoverRating > 0 ? hoverRating <= {{ $i }} : currentRating <= {{ $i }})
                }"
            ></i>
        </span>
    @endfor
</div>
