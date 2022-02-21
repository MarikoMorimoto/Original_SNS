@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <div class="card">
                <div class="card-header">{{ 'ログアウトが完了しました。' }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ 'またのご利用をお待ちしております!' }}
                    <a class="btn btn-light btn-outline-secondary w-100 my-4" href="{{ route('home') }}">トップページに移動</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection