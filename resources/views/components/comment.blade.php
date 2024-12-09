
     <div class="flex justify-evenly items-center">
        <div class="px-4 w-4/5 bg-gray-900 bg-opacity-30 rounded-md border border-black backdrop-filter backdrop-blur-sm">
            <p class="text-white text-left">{{ $comment['content'] }}</p>
            <p class="text-white text-right">Dodane przez: {{ $user['name'] }}</p>
        </div>
        <div class="like-box flex w-1/5 px-3 text-gray-500">
           
            <form class="mx-3" action="{{ route('posts.comment.like') }}" method="POST">
                @csrf
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                <button type="submit" class="like-btn">
                    <i class="fa-thumbs-up text-green-700 {{ auth()->user()->hasLiked($comment->id) ? 'fa-solid' : 'fa-regular' }}"></i>
                    <span class="like-count">{{ $comment->likes->count() ?? 0 }}</span>
                </button>
            </form>
            
           
            <form action="{{ route('posts.comment.dislike') }}" method="POST">
                @csrf
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                <button type="submit" class="dislike-btn">
                    <i class="fa-thumbs-down text-red-700 {{ auth()->user()->hasDisliked($comment->id) ? 'fa-solid' : 'fa-regular' }}"></i>
                    <span class="dislike-count">{{ $comment->dislikes->count() ?? 0 }}</span>
                </button>
            </form>
        </div>
    </div>
