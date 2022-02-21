@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('受信メールをご確認ください') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('ご登録いただいたメールアドレスに確認用のリンクをお送りしました。') }}
                        </div>
                    @endif

                    {{ __('このページにアクセスするには、ユーザー登録時にお送りしたメールでの認証が必要です。もし認証メールが見当たらない場合は、下記をクリックしてください。') }}
                    <br>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('確認メールを再送信する') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
