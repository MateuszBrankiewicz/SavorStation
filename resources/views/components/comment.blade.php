<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        // CSRF token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log('jestem')
        document.querySelectorAll('.like-box i').forEach(function(icon) {
            icon.addEventListener('click', function() {
                const id = this.getAttribute('data-post-id');
                const boxObj = this.parentElement;
                const like = this.classList.contains('like') ? 1 : 0;

                fetch("{{ route('posts.comment.like.dislike') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({
                            id: id,
                            like: like
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success.hasLiked) {
                            // Update dislike count
                            const dislikeIcon = boxObj.querySelector(".dislike");
                            if (dislikeIcon.classList.contains("fa-solid")) {
                                const dislikes = boxObj.querySelector(".dislike-count");
                                dislikes.textContent = parseInt(dislikes.textContent) - 1;
                            }

                            // Update like icon and count
                            boxObj.querySelector(".like").classList.replace("fa-regular", "fa-solid");
                            dislikeIcon.classList.replace("fa-solid", "fa-regular");

                            const likes = boxObj.querySelector(".like-count");
                            likes.textContent = parseInt(likes.textContent) + 1;

                        } else if (data.success.hasDisliked) {
                            // Update like count
                            const likeIcon = boxObj.querySelector(".like");
                            if (likeIcon.classList.contains("fa-solid")) {
                                const likes = boxObj.querySelector(".like-count");
                                likes.textContent = parseInt(likes.textContent) - 1;
                            }

                            // Update dislike icon and count
                            likeIcon.classList.replace("fa-solid", "fa-regular");
                            const dislikeIcon = boxObj.querySelector(".dislike");
                            dislikeIcon.classList.replace("fa-regular", "fa-solid");

                            const dislikes = boxObj.querySelector(".dislike-count");
                            dislikes.textContent = parseInt(dislikes.textContent) + 1;

                        } else {
                            // Reset both like and dislike counts and icons
                            const dislikeIcon = boxObj.querySelector(".dislike");
                            if (dislikeIcon.classList.contains("fa-solid")) {
                                const dislikes = boxObj.querySelector(".dislike-count");
                                dislikes.textContent = parseInt(dislikes.textContent) - 1;
                            }

                            const likeIcon = boxObj.querySelector(".like");
                            if (likeIcon.classList.contains("fa-solid")) {
                                const likes = boxObj.querySelector(".like-count");
                                likes.textContent = parseInt(likes.textContent) - 1;
                            }

                            likeIcon.classList.replace("fa-solid", "fa-regular");
                            dislikeIcon.classList.replace("fa-solid", "fa-regular");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            });
        });
    });
</script>
<div class="flex justify-evenly items-center flex-col">
   
<div class="px-4 w-4/5 bg-gray-900 bg-opacity-30 rounded-md border border-black backdrop-filter backdrop-blur-sm">

        <p class="text-white text-left">{{ $comment['content'] }}</p>
        <p class="text-white text-right">Dodane przez: {{ $user['name'] }}</p>


    </div>
    <div class="like-box">
        <i id="like-{{ $comment->id }}"
            data-post-id="{{ $comment->id }}"
            class="like fa-thumbs-up text-green-700 {{ auth()->user()->hasLiked($comment->id) ? 'fa-solid' : 'fa-regular' }}"></i>
        <span class="like-count">{{ $comment->likes->count() ?? 0 }}</span>
        <i id="dislike-{{ $comment->id }}"
            data-post-id="{{ $comment->id }}"
            class="dislike fa-thumbs-down text-red-700 {{ auth()->user()->hasDisliked($comment->id) ? 'fa-solid' : 'fa-regular' }}"></i>
        <span class="dislike-count">{{ $comment->dislikes->count() ?? 0 }}</span>
    </div>