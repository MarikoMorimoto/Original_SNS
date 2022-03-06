@extends('layouts.app')

@section('content')
<!-- カルーセル -->
<div class="container-fluid no-gutters">
    <div class="row">
        <div id="cl" class="carousel slide w-100" data-ride="carousel" data-pause="false">
            <ol class="carousel-indicators">
                <li data-target="#cl" data-slide-to="0" class="active"></li>
                <li data-target="#cl" data-slide-to="1"></li>
                <li data-target="#cl" data-slide-to="2"></li>
                <li data-target="#cl" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner carousel-fade">
                <div class="carousel-item active">
                    <img src="{{ asset('images/top-1.jpg') }}" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/top-2.jpg') }}" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/top-3.jpg') }}" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/top-4.jpg') }}" class="d-block w-100" alt="">
                </div>
            </div>
            <a class="carousel-control-prev" href="#cl" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#cl" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
</div>
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
<!-- 検索フォーム -->
<section class="container">
    <form action="{{ route('posts.index') }}" class="form-inline mt-3 justify-content-lg-left justify-content-center">
        <div class="row form-group w-100">
            <label class="sr-only" for="keyword">検索キーワード</label>
            <input type="search" name="keyword" value="{{ request('keyword') }}" class="form-control col-lg-5 col-9" placeholder="地名・花の名前など">
            <button type="submit" class="btn btn-light border col-lg-1 col-3">検索</button>
        </div>
    </form>
</section>
<!-- メインコンテンツ -->
<div class="container">
    <div class="row">
        <!-- 左サイドバー -->
        <div class="col-lg-3 col-12">
            <!-- lgサイズ以上の時 左側に表示 -->
            <div class="d-none d-lg-block">
                <h2><i class="far fa-thumbs-up fa-lg"></i> カテゴリ別画像</h2>
                <ul class="list-group list-group-flush">
                    @foreach ($categories as $category)
                        <li class="list-group-item list-group-item-action cursor-pointer"
                            onclick="document.getElementById('category-input-1').setAttribute('value', '{{ $category->name}}' );
                                    document.getElementById('category-form-1').submit();">
                            <i class="fas fa-hashtag" style="color:#333333;"></i> {{ $category->name }}
                        </li>
                    @endforeach
                    <form id="category-form-1" action="{{ route('posts.index') }}" class="d-none">
                        <input id="category-input-1" type="hidden" name="keyword">
                    </form>
                </ul>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <h2 class="d-flex"><i class="fas fa-camera fa-lg"></i><span class="ml-1">新着投稿</span>
                @auth
                    <div class="margin-left-auto"><a href="{{ route('posts.create') }}"><i class="fas fa-plus fa-lg"></i> 投稿する</a></div>
                @endauth
            </h2>
            <div class="row my-3">
                @forelse ($posts as $post)
                    <div class="col-md-4 col-6 mb-3">
                        @if ($post->image !== '')
                            <a href="{{ route('posts.show', $post) }}">
                                <img class="home_post" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                            </a>
                        @else
                            <a href="{{ route('posts.show', $post) }}">
                                <img class="home_post" src="{{ asset('images/no_image.png') }}" alt="no_image">
                            </a>
                        @endif
                    </div>
                @empty
                    <p class="col-12 mt-3">
                        投稿がありません
                    </p>
                @endforelse
                <div class="col-12 text-center mt-1">
                    <a href="{{ route('posts.index') }}" class="btn btn-light btn-outline-secondary col-md-8">投稿をもっと見る</a>
                </div>
            </div>
        </div>
        <!-- ログインユーザーにのみ表示 -->
        @auth
            <div class="col-lg-9 offset-lg-3 col-12">
                <h2><i class="fas fa-user-check fa-lg"></i> フォローユーザーの新着投稿</h2>
                <div class="row my-3">
                    @forelse ($follow_users_posts as $follow_users_post)
                        <div class="col-md-4 col-6 mb-3">
                            @if ($follow_users_post->image !== '')
                                <a href="{{ route('posts.show', $follow_users_post) }}">
                                    <img class="home_post" src="{{ asset('storage/' . $follow_users_post->image) }}" alt="{{ $follow_users_post->title }}">
                                </a>
                            @else
                                <a href="{{ route('posts.show', $follow_users_post) }}">
                                    <img class="home_post" src="{{ asset('images/no_image.png') }}" alt="no_image">
                                </a>
                            @endif
                        </div>
                    @empty
                        <p class="col-12 mt-3">
                            投稿がありません
                        </p>
                    @endforelse
                    <div class="col-12 text-center mt-1">
                        <a href="{{ route('follow.posts') }}" class="btn btn-light btn-outline-secondary col-md-8">フォローユーザーの投稿をもっと見る</a>
                    </div>   
                </div>
            </div>
        @endauth
        <!-- mdサイズ以下の時 フォローユーザーの投稿一覧の下に表示 -->
        <div class="col-12 d-lg-none d-block">
            <h2><i class="far fa-thumbs-up fa-lg"></i> カテゴリ別画像</h2>
            <div class="row my-3">
                @foreach ($categories as $category)
                    <div class="col-4">
                        <a class="btn btn-outline-secondary w-100 carsor-pointer my-2"
                            href="#"
                            onclick="event.preventDefault();
                                document.getElementById('category-input-2').setAttribute('value', '{{ $category->name}}' );
                                document.getElementById('category-form-2').submit();">{{ $category->name }}
                        </a>
                        <form id="category-form-2" action="{{ route('posts.index') }}" class="d-none">
                            <input id="category-input-2" type="hidden" name="keyword">
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
