@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>{{ $show_user->name }} さん のプロフィール</h2>
            <div class="text-center mt-3">
                @if ($show_user->image !== '')
                    <img class="img-fluid image-preview-max-height" src="{{ \Storage::url($show_user->image) }}">
                @else
                    <img class="img-fluid image-preview-max-height" src="{{ asset('images/profile_icon.png') }}">
                @endif
            </div>
            <div class="border-bottom p-2 mt-3 d-flex">
                <div class="avatar align-self-center">
                    @if ($show_user->image !== '')
                        <img src="{{ \Storage::url($show_user->image) }}" alt="avatar">
                    @else
                        <img src="{{ asset('images/profile_icon.png') }}" alt="avatar">
                    @endif
                </div>
                <div class="ml-2 align-self-center">
                    {{ $show_user->name }}
                </div>
                @auth
                    {{-- ログインユーザーと投稿元ユーザーが同一人物であればフォローボタンは表示しない --}}
                    @if ($user != $show_user)
                        {{-- ログインユーザー$user が 投稿元ユーザー$show_userをフォローしているならtrue --}}
                        @if ($user->isFollowing($show_user))
                            <button class="btn followed cursor-pointer follow_toggle" data-id="{{ $show_user->id }}">フォロー解除</button>
                        @else
                            <button class="btn cursor-pointer follow_toggle" data-id="{{ $show_user->id }}">フォロー</button>
                        @endif
                    @endif
                @endauth

            </div>
            <div class="text-left border p-2 px-3 mt-3 mb-2">
                @if ($show_user->profile !== '')
                    {!! nl2br(e($show_user->profile)) !!}
                @else
                    プロフィールは未入力です
                @endif
            </div>
            <h2 class="mt-4">{{ $show_user->name }} さんの新着投稿</h2>
            <div class="row text-center mt-2">
                @if ($count_posts > 0)
                    <div class="col-12">
                        <a href="{{ route('users.posts', $show_user->id ) }}">{{ $show_user->name }} さん の投稿一覧はこちら</a>
                    </div>
                @endif
                @forelse ($posts as $post)
                    <div class="col-md-6 mt-3">
                        @if ($post->image !== '')
                        <a href="{{ route('posts.show', $post) }}">
                            <img class="img-fluid image-preview-max-height" src="{{ asset('storage/' . $post->thumbnail($post->image)) }}" alt="{{ $post->title }}">
                        </a>
                        @else
                        <a href="{{ route('posts.show', $post) }}">
                            <img class="img-fluid image-preview-max-height" src="{{ asset('images/no_image.png') }}" alt="no_image">
                        </a>
                        @endif
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="mt-1">
                            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                        </div>
                        <div class="col-12 text-right">
                            {{-- いいねの実装 --}}
                            @auth
                                @if ($post->isLikedBy($user))
                                    いいね!!<i class="fas fa-heart fa-2x like_toggle liked cursor-pointer" data-id="{{ $post->id }}"></i>
                                    <span class="like-counter text-secondary font-weight-bold"> {{ $post->likes_count }}</span>
                                @else
                                    いいね!!<i class="far fa-heart fa-2x like_toggle cursor-pointer" data-id="{{ $post->id }}"></i>
                                    <span class="like-counter text-secondary font-weight-bold"> {{ $post->likes_count }}</span>
                                @endif
                            @else
                                いいね!!<i class="far fa-heart fa-2x text-secondary" data-toggle="modal" data-target="#modal"></i>
                                <span class="like-counter text-secondary font-weight-bold"> {{ $post->likes_count }}</span>
                                <!-- モーダル -->
                                <div class="modal fade" id="modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <p class="modal-title">いいね!!ボタンについて</p>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span aria-hidden="true">&#215;</span>
                                                </button>
                                            </div>
                                                <div class="modal-body">
                                                    <p class="text-left">
                                                        ログインすると いいね!! が利用できるようになります。
                                                    </p>
                                                <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">閉じる</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endauth
                        </div>
                        <div class="py-2 text-right">
                            {{ $post->created_at }}
                        </div>
                    </div>
                    <div class="col-12 py-2 border-bottom"></div>
                @empty
                    <p class="col-12 mt-3">
                        投稿はありません。
                    </p>
                @endforelse
        </div>
    </div>
</div>
<script>
    // いいねボタンの処理
    $('.like_toggle').on('click', function(){
        let clicked_like = $(this);
        let liked_post_id = $(clicked_like).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/likes/ajax',
            method: 'POST',
            data: {
                'post_id': liked_post_id
            },
        }).done(function(){
            // toggleClass() 対象となる要素のclass属性の追加・削除を繰り返すことができる
            $(clicked_like).toggleClass('liked far fas');
        }).fail(function(){
            alert('いいねボタンにエラーが発生しました。画面を更新してください。')
        });
    })

    // フォローボタンの処理
    $('.follow_toggle').on('click', function(){
        let clicked_follow = $(this);
        let follow_user_id = $(clicked_follow).data('id');
        console.log(follow_user_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/follow/ajax',
            method: 'POST',
            data: {
                'follow_id': follow_user_id
            },
        }).done(function(){
            $(clicked_follow).toggleClass('followed');
            $('.follow_toggle').text('フォロー');
            $('.followed').text('フォロー解除');
        }).fail(function(){
            alert('フォローボタンにエラーが発生しました。画面を更新してください。')
        });
    });

</script>

@endsection