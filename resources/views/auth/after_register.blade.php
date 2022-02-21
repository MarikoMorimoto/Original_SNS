@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ユーザー登録ありがとうございます！') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('ご登録のメールアドレスに認証メールをお送りしました。') }}
                    {{ __('認証メールの有効期限は60分です。ご確認のうえ、当サイトをお楽しみください！') }}
                    <a class="btn btn-light btn-outline-secondary w-100 my-4" href="{{ route('home') }}">トップページに移動</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection