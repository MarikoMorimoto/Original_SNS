@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>フォローしているユーザー一覧</h2>
            <p class="mt-1">フォロー した時間が新しい順に並んでいます</p>
            <div class="row">
                @forelse ($follow_users as $follow_user)
                    <div class="col-12 text-left d-flex mt-3">
                        <div class="avatar align-self-center">
                            @if ($follow_user->image !== '')
                                <img src="{{ \Storage::url($follow_user->thumbnail($follow_user->image)) }}" alt="avatar">
                            @else
                                <img src="{{ asset('images/profile_icon.png') }}" alt="avatar">
                            @endif
                        </div>
                        <div class="ml-2 align-self-center">
                            <a href="{{ route('users.show', $follow_user->id) }}">{{ $follow_user->name }}</a>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div>
                            <a href="{{ route('users.posts', $follow_user->id) }}">{{ $follow_user->name }} さん の投稿一覧</a>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-right mt-2">
                        <div>
                            フォローした時間 {{ $follow_user->pivot->created_at }}
                        </div>
                    </div>
                    <div class="col-12 py-2 border-bottom"></div>
                @empty
                <p class="col-12 mt-3">
                    まだ、フォローしたユーザー がいません。
                </p>
                @endforelse
                <div class="col-12 mt-3">
                    {{ $follow_users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>

@endsection