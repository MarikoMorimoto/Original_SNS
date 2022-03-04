@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <div class="card">
                <div class="card-header">
                    お問い合わせありがとうございます!
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        ご入力のメールアドレス宛に受付メールをお送りいたしました。<br>
                        お問い合わせには順次対応しております。<br>
                        ご返信まで日数がかかる場合がありますが、何卒ご了承ください。<br>
                    </div>
                    <div class="row justify-content-center">
                        <a class="btn btn-light btn-outline-secondary col-md-8 my-4" href="{{ route('home') }}">トップページに移動</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection