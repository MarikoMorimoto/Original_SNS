@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>{{ $user->name }} さん のマイページ</h2>
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
            <div class="row justify-content-center">
                @if ($user->image !== '')
                <img class="preview img-fluid col-9 col-md-7 mt-3" src="{{ \Storage::url($user->image) }}">
                @else
                <img class="preview img-fluid col-9 col-md-7 mt-3" src="{{ asset('images/profile_icon.png') }}">
                @endif
            </div>
            <form class="mt-3" action="{{ route('users.edit_image') }}">
                <div class="text-right">
                    <input type="submit" class="btn btn-light btn-outline-secondary" value="プロフィール画像を変更">
                </div>
            </form>
            <div class="border-bottom p-2  mt-3">
                {{ $user->name }}
            </div>
            <div class="text-left border p-2 px-3 mt-3 mb-2">
                @if ($user->profile !== '')
                    {!! nl2br(e($user->profile)) !!}
                @else
                    プロフィールは未入力です
                @endif
            </div>
            <form class="mt-3" action="{{ route('users.edit') }}">
                <div class="text-right">
                    <input type="submit" class="btn btn-light btn-outline-secondary" value="プロフィールを編集">
                </div>
            </form>
            <p class="text-center m-3">
                --- ここより下の項目は他ユーザーからは見えません ---
            </p>
            <div class="row justify-content-center">
                <ul class="col-12 col-md-10 col-lg-9 list-group list-group-flush">
                    <li class="list-group-item list-group-item-action cursor-pointer">
                        <i class="fas fa-heart"> 未定</i>
                    </li>
                    <li class="list-group-item list-group-item-action cursor-pointer">
                        <i class="fas fa-heart"> 未定</i>
                    </li>
                    <li class="list-group-item list-group-item-action cursor-pointer">
                        <i class="fas fa-heart"> 未定</i>
                    </li>
                    <li class="list-group-item list-group-item-action cursor-pointer">
                        <i class="fas fa-heart"> 未定</i>
                    </li>
                </ul>

            </div>

            <a href="{{ route('likes.index') }}" class="">いいね!! した投稿一覧</a>
            <a href="{{ route('users.posts', $user->id ) }}" class="">{{ $user->name }}さんの投稿一覧</a>
            <a href="#" class="dropdown-item">mypage3</a>


        </div>
    </div>
</div>

@endsection