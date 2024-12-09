<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class RatingComponent extends Component
{
    public $recipe;
    public $maxStars;

    public function __construct($recipe, $maxStars = 5)
    {
        $this->recipe = $recipe;
        $this->maxStars = $maxStars;
    }

    public function render(): View
    {
        return view('components.rating-component');
    }
}