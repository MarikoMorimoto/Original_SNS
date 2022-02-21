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
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->
                    こんにちは！
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 検索フォーム -->
<section class="container">
    <form class="form-inline my-3 justify-content-lg-left justify-content-center">
        <div class="row form-group w-100">
            <label class="sr-only" for="keyword">検索キーワード</label>
            <input type="search" class="form-control col-lg-5 col-9" placeholder="地名・花の名前など">
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
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-hashtag" style="color:#333333;"></i> 道ばた</a>
                    <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-hashtag" style="color:#333333;"></i> 公園</a>
                    <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-hashtag" style="color:#333333;"></i> ガーデニング</a>
                    <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-hashtag" style="color:#333333;"></i> 観光地</a>
                    <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-hashtag" style="color:#333333;"></i> 秘密の場所</a>
                    <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-hashtag" style="color:#333333;"></i> その他</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <h2><i class="fas fa-camera fa-lg"></i> 新着画像</h2>
            <div class="row my-3">
                <div class="col-md-3 col-6">
                    img object-fit を使う ボックスの大きさに合わせて拡大・縮小
                </div>
                <div class="col-md-3 col-6">
                    スライダー表示もかっこよさそう
                </div>
                <div class="col-md-3 col-6">
                    スライダー表示もかっこよさそう
                </div>
                <div class="col-md-3 col-6">
                    スライダー表示もかっこよさそう
                </div>                                
            </div>
        </div>        
        <!-- mdサイズ以下の時 新着画像の下に表示 -->
        <div class="col-12">
            <div class="d-lg-none d-block">
                <h2><i class="far fa-thumbs-up fa-lg"></i> カテゴリ別画像</h2>
                <div class="row">
                    <div class="col-4">
                        <a class="btn btn-outline-secondary w-100 my-4" href="#">道ばた</a>
                    </div>
                    <div class="col-4">
                        <a class="btn btn-outline-secondary w-100 my-4" href="#">公園</a>
                    </div>
                    <div class="col-4">
                        <a class="btn btn-outline-secondary w-100 my-4" href="#">ガーデニング</a>
                    </div>
                    <div class="col-4">
                        <a class="btn btn-outline-secondary w-100 mb-4" href="#">観光地</a>
                    </div>
                    <div class="col-4">
                        <a class="btn btn-outline-secondary w-100 mb-4" href="#">秘密の場所</a>
                    </div>
                    <div class="col-4">
                        <a class="btn btn-outline-secondary w-100 mb-4" href="#">その他</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-12 offset-lg-3">
            <h2><i class="fas fa-medal fa-lg"></i> 今週のランキング</h2>
            <div class="row">
                <div class="col-md-6 col-12 my-3">
                    <figure class="text-center">
                        <img>
                        <figucaption>一位: 画像のタイトル</figucaption>
                    </figure>
                    <p>画像の詳細情報</p>
                    <div class="row">
                        <button class="col-8 btn btn-light btn-outline-secondary mx-auto d-none d-md-block">続きを読む</button>
                    </div>
                    <button class="btn btn-light btn-outline-secondary w-100 d-md-none d-block">続きを読む</button>    
                </div>
                <div class="col-md-6 col-12 my-3">
                    <figure class="text-center">
                        <img>
                        <figucaption>二位: 画像のタイトル</figucaption>
                    </figure>
                    <p>画像の詳細情報</p>
                    <div class="row">
                        <button class="col-8 btn btn-light btn-outline-secondary mx-auto d-none d-md-block">続きを読む</button>
                    </div>
                    <button class="btn btn-light btn-outline-secondary w-100 d-md-none d-block">続きを読む</button>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
