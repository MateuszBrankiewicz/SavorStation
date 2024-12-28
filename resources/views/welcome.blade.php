<x-app-layout>
    <section class="flex flex-col justify-between items-center min-h-screen bg-g00ray-9 text-gray-200">
        <!-- Sekcja powitalna -->
        <div class="text-center mt-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">Witamy w Przepisowej Przystani!</h1>
            <p class="text-lg md:text-xl mb-6">Odkrywaj, dziel się i ciesz się pysznymi przepisami z całego świata.</p>
        </div>

        <!-- Pasek wyszukiwania -->
        <x-responsive-search-bar class="mb-12 w-3/4 md:w-1/2"></x-responsive-search-bar>

        <!-- Sekcja kategorii -->
        <div class="w-full py-10  text-center">
            <h2 class="text-3xl font-semibold text-gray-100 mb-8">Kategorie</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 px-12">
                <x-category-circle category="3" text="Kuchnia polska" faIconClass="assets/icons/poland.svg"></x-category-circle>
                <x-category-circle category="9" text="Kuchnia amerykańska" faIconClass="assets/icons/american.png"></x-category-circle>
                <x-category-circle category="4" text="Kuchnia chińska" faIconClass="assets/icons/china.png"></x-category-circle>
                <x-category-circle category="7" text="Kuchnia francuska" faIconClass="assets/icons/france.webp"></x-category-circle>
                <x-category-circle category="10" text="Kuchnia grecka" faIconClass="assets/icons/greece.webp"></x-category-circle>
                <x-category-circle category="6" text="Kuchnia indyjska" faIconClass="assets/icons/india.png"></x-category-circle>
                <x-category-circle category="1" text="Kuchnia włoska" faIconClass="assets/icons/italy.png"></x-category-circle>
                <x-category-circle category="5" text="Kuchnia japońska" faIconClass="assets/icons/japan.png"></x-category-circle>
                <x-category-circle category="2" text="Kuchnia meksykańska" faIconClass="assets/icons/mexico.png"></x-category-circle>
                <x-category-circle category="8" text="Kuchnia tajska" faIconClass="assets/icons/tailand.webp"></x-category-circle>
            </div>
        </div>
    </section>
</x-app-layout>
