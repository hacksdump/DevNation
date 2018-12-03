<div class="container col-lg-6">
    @if($posts)
        @foreach($posts as $post)
            <div class="card container">
                <a href="/user/{{ $post['user']['username'] }}">
                    {{ $post['user']['name'] }}
                </a>
                <div>
                    {{ $post['created_at'] }}
                </div>
                <a href="/post/{{$post['id']}}">
                    {{ $post['question'] }}
                </a>
            </div>
        @endforeach
    @else
        There are no posts yet.
    @endif

</div>
