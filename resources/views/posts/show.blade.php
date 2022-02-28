@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
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
            <div class="row justify-content-center mt-4">
                <div class="col-12">
                    @if ($post->image !== '')
                    <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                    @else
                    <img class="img-fluid" src="{{ asset('images/no_image.png') }}" alt="no_image">
                    @endif
                </div>
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
                            @else
                                いいね!!<i class="far fa-heart fa-2x like_toggle cursor-pointer" data-id="{{ $post->id }}"></i>
                            @endif
                        @endauth
                </div>
                <div class="col-12 py-2 text-right py-3">
                    カテゴリー : {{ $post->category->name}}<br>
                    {{ $post->created_at }}
                </div>
                <div class="col-12 text-left">
                    投稿者: {{ $post->user->name }}
                </div>
                <div class="col-12 mt-3 text-right">
                    <i class="far fa-comment-dots fa-2x"></i>
                    <span>コメント</span>
                    @guest
                        <div>
                            <span>ユーザー登録をするとコメントができるようになります!</span>
                            <div>
                                <a class="btn btn-link" href="{{ route('register') }}">{{ 'ユーザー登録がお済みでない方はこちら' }}</a>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('comments.add', $post) }}">
                            @csrf
                            <div class="form-group">
                                <label for="comment">この投稿について感想など、コメントを追加しませんか？</label>
                                <textarea class="form-control count_comment" id="comment" name="comment" placeholder="コメントを入力" rows="2">{{ (old('comment')) }}</textarea>
                                <div>
                                    <span class="now_count_comment">0</span> / 150 文字
                                </div>
                                <span class="over_count_comment"></span>
                            </div>
                            <input class="submit btn btn-light btn-outline-secondary" type="submit" value="コメントを追加">
                        </form>
                    @endguest

                    @if ($comments->count() > 0)
                        @foreach ($comments as $comment)
                            <div class="text-left border p-2 px-3 mt-3">
                                <div class="border-bottom pb-2 mb-2">
                                    {{ $comment->user->name }} さん より
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
                                                <input type="submit" class="btn btn-light btn-outline-secondary" value="コメントを削除">
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
                    {{ $comments->links() }}
                </div>
                <div class="col-12 row justify-content-center">
                    <button class="btn btn-light btn-outline-secondary col-md-8 my-4" onClick="history.back()">戻る</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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