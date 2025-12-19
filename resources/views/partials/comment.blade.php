<div class="mb-4" style="margin-left: {{ $depth * 20 }}px;">
    <div class="border-l-2 border-gray-200 pl-4">
        <div class="flex items-start mb-2">
            <div class="flex flex-col items-center mr-2">
                @auth
                    <form action="{{ route('comments.vote', $comment) }}" method="POST">
                        @csrf
                        <input type="hidden" name="vote" value="1">
                        <button type="submit" class="text-gray-400 hover:text-orange-600 text-xs">▲</button>
                    </form>
                @else
                    <span class="text-gray-400 text-xs">▲</span>
                @endauth

                <span class="text-xs font-bold {{ $comment->votes > 0 ? 'text-orange-600' : ($comment->votes < 0 ? 'text-blue-600' : 'text-gray-600') }}">
                    {{ $comment->votes }}
                </span>

                @auth
                    <form action="{{ route('comments.vote', $comment) }}" method="POST">
                        @csrf
                        <input type="hidden" name="vote" value="-1">
                        <button type="submit" class="text-gray-400 hover:text-blue-600 text-xs">▼</button>
                    </form>
                @else
                    <span class="text-gray-400 text-xs">▼</span>
                @endauth
            </div>

            <div class="flex-1">
                <div class="text-sm text-gray-600 mb-1">
                    <a href="{{ route('users.show', $comment->user) }}" class="font-bold hover:underline">u/{{ $comment->user->name }}</a>
                    • {{ $comment->created_at->diffForHumans() }}
                </div>
                <p class="text-gray-800 whitespace-pre-wrap">{{ $comment->content }}</p>

                @auth
                    <div class="mt-2 text-sm">
                        <button onclick="toggleReplyForm({{ $comment->id }})" class="text-gray-600 hover:underline">Reply</button>
                        @if($comment->user_id === auth()->id())
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endif
                    </div>

                    <div id="reply-form-{{ $comment->id }}" class="hidden mt-2">
                        <form action="{{ route('comments.store', $comment->post) }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <textarea name="content" rows="3" required
                                      class="w-full px-3 py-2 border rounded focus:outline-none focus:border-orange-500"></textarea>
                            <button type="submit" class="mt-2 bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 text-sm">
                                Reply
                            </button>
                            <button type="button" onclick="toggleReplyForm({{ $comment->id }})" class="mt-2 text-gray-600 hover:underline text-sm ml-2">
                                Cancel
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>

        @foreach($comment->replies as $reply)
            @include('partials.comment', ['comment' => $reply, 'depth' => $depth + 1])
        @endforeach
    </div>
</div>

@if($depth === 0)
<script>
    function toggleReplyForm(commentId) {
        const form = document.getElementById('reply-form-' + commentId);
        form.classList.toggle('hidden');
    }
</script>
@endif
