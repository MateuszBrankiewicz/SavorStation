<div class="flex flex-col sm:flex-row justify-evenly items-center gap-4 sm:gap-0">
    <div class="px-4 w-full sm:w-4/5 bg-gray-900 bg-opacity-30 rounded-md border border-black backdrop-filter backdrop-blur-sm">
        <p class="text-white text-left">{{ $comment['content'] }}</p>
        <p class="text-white text-right">Dodane przez: {{ $user['name'] }}</p>
    </div>

    <div class="like-box flex w-full sm:w-1/5 justify-center sm:justify-end gap-2 text-gray-500">
        @if (auth()->check())
        <form class="flex items-center" action="{{ route('posts.comment.like') }}" method="POST">
            @csrf
            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            <button type="submit" class="like-btn flex items-center">
                <i class="fa-thumbs-up text-green-700 {{ auth()->user()->hasLiked($comment->id) ? 'fa-solid' : 'fa-regular' }}"></i>
                <span class="like-count ml-1">{{ $comment->likes->count() ?? 0 }}</span>
            </button>
        </form>

        <form class="flex items-center" action="{{ route('posts.comment.dislike') }}" method="POST">
            @csrf
            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
            <button type="submit" class="dislike-btn flex items-center">
                <i class="fa-thumbs-down text-red-700 {{ auth()->user()->hasDisliked($comment->id) ? 'fa-solid' : 'fa-regular' }}"></i>
                <span class="dislike-count ml-1">{{ $comment->dislikes->count() ?? 0 }}</span>
            </button>
        </form>
        @else
        <div class="flex items-center">
            <i class="fa-thumbs-up text-green-700 fa-regular mx-1"></i>
            <span class="like-count mr-1">{{ $comment->likes->count() ?? 0 }}</span>
            <i class="fa-thumbs-down text-red-700 fa-regular mx-1"></i>
            <span class="dislike-count">{{ $comment->dislikes->count() ?? 0 }}</span>
        </div>
        @endif
    </div>
</div>