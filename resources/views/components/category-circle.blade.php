<a href="{{route('search.category', ['categoryId' => $category])}}">
<div class="flex flex-col rounded-lg border w-[200px] h-[200px] justify-center p-3 align-center border-gray-200">
           <img src="{{asset($iconPath)}}"  alt="icon">
           <span class=" font-bold text-xl">{{$text}}</span>
           </div>
           </a>