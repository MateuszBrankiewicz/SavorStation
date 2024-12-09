<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
Use App\Models\User;
class RecipeComponent extends Component
{
    public $title;

    public $username;

    public $description;

    public $image;

    public $ingridients;
    public $rating;
    public $id;
    public function __construct($title, $username, $description, $ingridients, $image, $rating, $id)
{
    $this->title = $title;
    $this->id = $id;
    $this->username = $this->getUserName($username);
    $this->description = $description;
    $this->ingridients = $ingridients;
    $this -> id = $id;    
    $this->image = $image;
    $this ->rating = round($rating,2);
}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recipe-component');
    }
    private function getUserName($user_id){
        if($user_id === 'Anonymous'){
            return $user_id;
        }
        $userName = User::find($user_id);
        return $userName["name"];
        
    }
  
}
