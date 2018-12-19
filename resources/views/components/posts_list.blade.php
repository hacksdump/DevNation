<div class="container">
    @if($posts)
        @foreach($posts as $post)

            <div class="card container shadow post-list">
                <a href="/user/{{ $post['user']['username'] }}">
                    <img class="avatar" src="{{ $post['user']['avatar'] }}">
                    {{ $post['user']['name'] }}
                </a>
                <a class="question" href="/post/{{$post['id']}}">
                    {{ $post['question'] }}
                </a>

                <div class="date-time">
                    {{ $post['created_at'] }}
                </div>
                <div>
                    {{$post['answers_count']}} answers
                </div>
                @if($post['language'])
                    <div class="language-container">
                    <span>Language: </span>
                    <a class="language-name" href="/tag/{{$post['language']}}">{{ $post['language'] }}</a>
                    </div>
                    @endif
            </div>
        @endforeach
    @else
        There are no posts yet.
    @endif
</div>
