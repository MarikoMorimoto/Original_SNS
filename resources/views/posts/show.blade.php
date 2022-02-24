@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>投稿詳細</h2>
            <div class="row text-center mt-2">
                    <div class="mt-3">
                    @if ($post->image !== '')
                    <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                    @else
                    <img class="img-fluid" src="{{ asset('images/no_image.png') }}" alt="no_image">
                    @endif
                </div>
                <div class="mt-3">
                    <div class="mt-1">
                        {{ $post->title }}
                    </div>
                    <div class="text-left">
                        {!! nl2br(e($post->comment)) !!}
                    </div>
                    <div class="py-2 text-right">
                        {{ $post->created_at }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection