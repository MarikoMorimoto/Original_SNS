@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>投稿詳細</h2>
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
                <div class="col-12 py-2 text-right py-3">
                    {{ $post->created_at }}
                </div>
                <div class="col-12 text-left mt-3">
                    投稿者: {{ $post->user->name }}
                </div>
                <div class="col-12 row justify-content-center">
                    <button class="btn btn-light btn-outline-secondary col-md-8 my-4" onClick="history.back()">戻る</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection