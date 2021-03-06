@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>投稿詳細</h2>
            <!-- セッションにフラッシュメッセージがセットされている時だけ表示 -->
            @if (session('status'))
            <div class="container mt-3">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Dashboard') }}</div>
                            <div class="card-body">
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-12">
            <div class="text-center mt-4">
                @if ($post->image !== '')
                <img class="img-fluid image-max-height" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                @else
                <img class="img-fluid image-max-height" src="{{ asset('images/no_image.png') }}" alt="no_image">
                @endif
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <div class="row">
                <div class="col-12 text-center mt-3">
                    {{ $post->title }}
                </div>
                <div class="col-12 text-left mt-3">
                    {!! nl2br(e($post->comment)) !!}
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
                                            <p class="modal-title">いいね!! ボタンについて</p>
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
                <div class="col-12 py-2 text-right py-3">
                    <div>カテゴリー : {{ $post->category->name}}</div>
                    <div class="mt-1">
                        花の名前 : 
                        @if ($post->flower_name !== '')
                            {{ $post->flower_name }}
                        @else
                            未入力
                        @endif
                    </div>
                    <div class="mt-1">
                        {{ $post->created_at }}
                    </div>
                    <div class="mt-1">
                        <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-text="Flowers | 素敵な花の写真をシェア！" data-hashtags="Flowers" data-show-count="false">Tweet</a>
                        <div class="line-it-button" data-lang="ja" data-type="share-a" data-env="REAL" data-color="default" data-size="small" data-count="false" data-ver="3" style="display: none;"></div>
                    </div>

                    
                    @auth
                        @if ($post->user->id === $user->id)
                            <form action="{{ route('posts.edit', $post) }}" class="mt-2">
                                <input type="submit" class="btn btn-light btn-outline-secondary" value="投稿を編集"> 
                            </form>
                        @endif
                    @endauth
                </div>
                <div class="col-12 text-left d-flex">
                    <div class="avatar align-self-center">
                        @if ($post->user->image !== '')
                            <img src="{{ \Storage::url($post->user->thumbnail($post->user->image)) }}" alt="avatar">
                        @else
                            <img src="{{ asset('images/profile_icon.png') }}" alt="avatar">
                        @endif
                    </div>
                    <div class="ml-2 align-self-center">
                        <a href="{{ route('users.show', $post->user->id) }}">{{ $post->user->name }}</a>
                    </div>

                    @auth
                        {{-- ログインユーザー$user が 投稿元ユーザーと同じでないとき表示 --}}
                        @if ($user != $post->user)
                            {{-- ログインユーザー$user が 投稿元ユーザー$post->userをフォローしているならtrue --}}
                            @if ($user->isFollowing($post->user))
                                <button class="btn followed cursor-pointer follow_toggle" data-id="{{ $post->user->id }}">フォロー解除</button>
                            @else
                                <button class="btn cursor-pointer follow_toggle" data-id="{{ $post->user->id }}">フォロー</button>
                            @endif
                        @endif
                    @endauth
                </div>
                <div class="col-12 mt-5 text-left">
                    <div class="d-flex">
                        <div>
                            <i class="far fa-comment-dots fa-2x"></i>
                        </div>
                        <div class="align-self-center">
                            <span class="h5 ml-1">コメント</span>
                        </div>
                    </div>
                    @guest
                        <div>
                            <span>ログインをするとコメントができるようになります!</span>
                            <div>
                                <a class="btn btn-link" href="{{ route('register') }}">{{ 'ユーザー登録がお済みでない方はこちら' }}</a>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('comments.add', $post) }}">
                            @csrf
                            <div class="form-group mt-1">
                                <label for="comment">この投稿について感想など、コメントを追加しませんか？</label>
                                <textarea class="form-control count_comment @error('comment') is-invalid @enderror" id="comment" name="comment" placeholder="コメントを入力してください" rows="2">{{ (old('comment')) }}</textarea>
                                <div class="text-left">
                                    <span class="now_count_comment">0</span> / 150 文字
                                </div>
                                <span class="over_count_comment"></span>
                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="text-right">
                                <input class="submit btn btn-light btn-outline-secondary mb-1" type="submit" value="コメントを追加">
                            </div>
                        </form>
                    @endguest

                    @if ($comments->count() > 0)
                        @foreach ($comments as $comment)
                            <div class="text-left border p-2 px-3 mt-3">
                                <div class="border-bottom pb-2 mb-2 d-flex">
                                    <div class="avatar comment align-self-center">
                                        @if ($comment->user->image !== '')
                                            <img src="{{ \Storage::url($comment->user->thumbnail($comment->user->image)) }}" alt="avatar">
                                        @else
                                            <img src="{{ asset('images/profile_icon.png') }}" alt="avatar">
                                        @endif
                                    </div>
                                    <div class="ml-2 align-self-center">
                                        <a href="{{ route('users.show', $comment->user->id) }}">
                                            {{ $comment->user->name }}
                                        </a>
                                            さん より
                                    </div>
                                </div>
                                <div>
                                    {!! nl2br(e($comment->comment)) !!}
                                </div>
                                <div class="text-right">
                                    {{ $comment->created_at }}
                                </div>
                                @auth
                                    @if ($comment->user->id === $user->id)
                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                            @csrf
                                            @method('delete')
                                            <div class="text-right">
                                                <input type="submit" class="delete btn btn-outline-danger" value="コメントを削除">
                                            </div>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        @endforeach
                    @else
                        <div class="text-left border p-2 px-3 mt-3">
                            まだこの投稿についてのコメントはありません
                        </div>
                    @endif
                </div>
                <div class="col-12 mt-2">
                    {{ $comments->appends(request()->query())->links() }}
                </div>
                <div class="col-12 text-center">
                    <button class="btn btn-light btn-outline-secondary col-md-8 my-4" onClick="history.back()">戻る</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // LINE共有ボタンに現在開いているページのURLを取得して上書き
    // $(document).ready(function(){~}) ページ全体が読み込まれたらreadyのfunction内の処理を行う
    $(document).ready(function(){
        let now_url = location.href
        $('.line-it-button').data('url', now_url);
    });

    // 削除ボタンがクリックされたとき、ダイアログを表示
    $('.delete').on('click', function(){
        // confirmメソッド ダイアログに表示するメッセージを指定することができる
        let checked = confirm('本当にコメントを削除しますか？削除後は、コメントを元には戻せません。');
        if (checked == true) {
            return true;
        } else {
            return false;
        }
    });

    $('.count_comment').on('input', function(){
        let count = $(this).val().replace(/\n/g, "\r\n").length;
        $('.now_count_comment').text(count);
        if (count > 150) {
            $('.now_count_comment').addClass('text-danger');
            $('.over_count_comment').text('コメントの入力は150文字以下にしてください').addClass('text-danger');
            $('.submit').prop('disabled', true);
        } else {
            $('.now_count_comment').removeClass('text-danger');
            $('.over_count_comment').empty();
            $('.submit').prop('disabled', false);
        }
    });

    // リロード時に初期文字列が入っていた時の処理
    $('.count_comment').trigger('input');


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
        }).done(function(data){
            // toggleClass() 対象となる要素のclass属性の追加・削除を繰り返すことができる
            $(clicked_like).toggleClass('liked far fas');
            $(clicked_like).next('.like-counter').text(data.post_likes_count);
        }).fail(function(){
            alert('いいねボタンにエラーが発生しました。画面を更新してください。')
        });
    });
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