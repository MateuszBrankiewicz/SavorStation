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

    public $image_path;

    public $ingridients;

    public function __construct($title, $username, $description, $ingridients, $image_path)
{
    $this->title = $title;
    $this->username = $this->getUserName($username);
    $this->description = $description;
    $this->ingridients = $ingridients;
    $this -> $image_path = $image_path;

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
