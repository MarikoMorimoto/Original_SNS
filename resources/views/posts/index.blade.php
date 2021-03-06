@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>投稿一覧</h2>
            <div class="row text-center mt-2">
                <!-- 検索フォーム -->
                <section class="col-12">
                    <form action="{{ route('posts.index') }}" class="form-inline my-3 justify-content-center">
                        <div class="row form-group w-100">
                            <label class="sr-only" for="keyword">検索キーワード</label>
                            <input type="search" name="keyword" value="{{ $keyword }}" class="form-control col-10" placeholder="地名・花の名前など">
                            <button type="submit" class="btn btn-light border col-2">検索</button>
                        </div>
                    </form>
                </section>

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
                            @auth
                                @if ($post->user->id === $user->id)
                                    <form action="{{ route('posts.edit', $post) }}">
                                        <input type="submit" class="btn btn-light btn-outline-secondary" value="投稿を編集"> 
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <div class="col-12 py-2 border-bottom"></div>
                @empty
                <p class="col-12 mt-3">
                    投稿はありません。
                </p>
                @endforelse
                <div class="col-12 mt-3">
                {{-- 
                    検索条件を保ったまま次のページに遷移するためにページネーションに下記を追加
                    ・appends()メソッドで配列を渡す
                    ・request()メソッドで、ページで送信されるリクエストを取得する
                    ・request()メソッドの中で、さらにquery()メソッドを使うことでリクエストの中のクエリストリングのみを取得できる。
                --}}    
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // いいねボタン
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
            console.log(data);
            // toggleClass() 対象となる要素のclass属性の追加・削除を繰り返すことができる
            $(clicked_like).toggleClass('liked far fas');
            $(clicked_like).next('.like-counter').text(data.post_likes_count);
        }).fail(function(){
            alert('いいねボタンにエラーが発生しました。画面を更新してください。')
        });
    })
</script>
@endsection