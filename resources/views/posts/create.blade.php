@extends('layouts.app')

@section('content')
<div class="container">
    <div>
        <h2>新規投稿</h2>
        <div class="mt-3">
            {{-- エラーメッセージを出力 --}}
            {{-- Laravelでは、バリデーションの実施時にチェックに引っかかった値があると
                自動的に$errors という変数に、エラーメッセージを準備する。
                なお、この$errors はViewErrorBag型という特殊なデータ型のため
                以下のように記述することで配列のように扱うことが可能。--}}

            @foreach($errors->all() as $error)
            <p class="error text-danger">{{ $error }}</p>
            @endforeach

            {{-- 画像データ送信のため enctype を設定 --}}
            <form 
                method="POST"
                action="{{ route('posts.store') }}"
                enctype="multipart/form-data"
            >
                @csrf
                <div>
                    <label>
                        画像を選択:
                        <input type="file" name="image" value="{{ old('image') }}">
                    </label>
                </div>
                <div>
                    <label>
                        タイトル:
                    {{-- old()という関数を使えばエラーの際に入力した値がクリアされない --}}
                    <input type="text" name="title" placeholder="入力してください" value="{{ old('title') }}">
                    </label>
                </div>
                
                <div>
                    <label>
                        コメント:<br>
                        {{-- 改行を有効にしつつ、エスケープする --}}
                        <textarea name="comment" placeholder="画像についてコメントを入力してください" cols="50" rows="10">{!! nl2br(e(old('comment'))) !!}</textarea>
                    </label>
                </div>
                
                <div>
                    <label>
                        カテゴリー:
                        <select name="category_id">
                            <option value="">選択してください</option>
                            @forelse ($categories as $category)
                                <option value="{{ $category->id }}">
                                   {{ $category->name }}
                                </option>
                            @empty
                                カテゴリーは未設定です
                            @endforelse
                        </select>
                    </label>
                </div>
                <input class="btn btn-light btn-outline-secondary" type="submit" value="投稿する">
            </form>
        </div>
    </div>
</div>

@endsection