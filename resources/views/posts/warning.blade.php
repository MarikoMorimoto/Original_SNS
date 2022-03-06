@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <div class="card">
                <div class="card-header">ページにアクセスできませんでした</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-info" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    アクセスしたいURLと、ログイン状態をご確認ください。
                    <div class="row justify-content-center">
                        <a class="btn btn-light btn-outline-secondary col-md-8 my-4" href="{{ route('home') }}">トップページに移動</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection