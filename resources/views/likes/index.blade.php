@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>いいねした投稿一覧</h2>
            <p class="mt-1">いいね!! した時間が新しい順に並んでいます</p>
            <div class="row text-center mt-2">
                @forelse ($posts as $post)
                    <div class="col-md-6 mt-3">
                        @if ($post->image !== '')
                        <a href="{{ route('posts.show', $post) }}">
                            <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        </a>
                        @else
                        <a href="{{ route('posts.show', $post) }}">
                            <img class="img-fluid" src="{{ asset('images/no_image.png') }}" alt="no_image">
                        </a>
                        @endif
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="mt-1">
                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                        </div>
                        <div class="py-2 text-right">
                            {{ $post->created_at }}
                        </div>
                        <div class="col-12 text-right">
                            いいね!!<i class="fas fa-heart fa-2x like_toggle liked cursor-pointer" data-id="{{ $post->id }}"></i><br>
                            いいね!! した時間 {{ $post->pivot->created_at }}
                        </div>
                    </div>
                    <div class="col-12 py-2 border-bottom"></div>
                @empty
                <p class="col-12 mt-3">
                    まだ、いいね!! した投稿がありません。
                </p>
                @endforelse
                <div class="col-12 mt-3">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.like_toggle').on('click', function(){
        let clicked_like = $(this);
        let likedPostId = $(clicked_like).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/likes/ajax',
            method: 'POST',
            data: {
                'post_id': likedPostId
            },
        }).done(function(){
            // toggleClass() 対象となる要素のclass属性の追加・削除を繰り返すことができる
            $(clicked_like).toggleClass('liked far fas');
        }).fail(function(){
            alert('いいねボタンについてエラーが発生しました。')
        });
    })
</script>

@endsection