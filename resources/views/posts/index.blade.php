@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>投稿一覧</h2>
            <div class="row text-center mt-2">
                @forelse ($posts as $post)
                    <div class="col-md-6 mt-3">
                        @if ($post->image !== '')
                        <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        @else
                        <img class="img-fluid" src="{{ asset('images/no_image.png') }}" alt="no_image">
                        @endif
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="mt-1">
                            {{ $post->title }}
                        </div>
                        <div class="py-2 text-right">
                            {{ $post->created_at }}
                        </div>
                    </div>
                    <div class="col-12 py-2 border-bottom"></div>
                @empty
                <p class="mt-3">
                    投稿はありません。
                </p>
                @endforelse
            </div>
            {{ $posts->links() }}
        </div>
    </div>
</div>

@endsection