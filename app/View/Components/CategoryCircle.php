<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryCircle extends Component
{
    /**
     * Create a new component instance.
     */
    public $text;
    public $iconPath;
    public $category;
    public function __construct($text, $faIconClass,$category)
    {
        $this->text = $text;
        $this->iconPath = $faIconClass;
        $this -> category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category-circle');
    }
}
