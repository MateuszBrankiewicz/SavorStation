<?php

namespace App\View\Components;

use App\Models\Ingredient;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
Use App\Models\User;
use App\Models\Recipe;
use App\Models\RecipeCategory;

class RecipeComponent extends Component
{
    public $title;

    public $username;

    public $description;

    public $image;

    public $ingridients;
    public $rating;
    public $id;
    public $user_id;
    public $recipeCategory;
    public $makeTime;
    public function __construct($title, $username, $description, $ingridients, $image, $rating, $id, $categoryid,$makeTime)
{
    $this->title = $title;
    $this->id = $id;
    $this ->user_id = $username;
    $this->username = $this->getUserName($username);
    $this->description = $description;
    $this->ingridients = Ingredient::getIngredients($ingridients);
    $this -> id = $id;    
    $this->image = $image;
    $this ->rating = round($rating,2);
    $this -> recipeCategory = $this -> takeCategory($categoryid);
    $this-> makeTime = $makeTime;
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
    private function takeCategory($category_id){
        $category=  RecipeCategory::where('id',$category_id) -> get();
        return $category[0]['category'];
    }
}
