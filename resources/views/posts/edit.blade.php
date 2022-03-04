@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>投稿編集</h2>
            {{-- エラーメッセージを出力 --}}
            {{-- Laravelでは、バリデーションの実施時にチェックに引っかかった値があると
                自動的に$errors という変数に、エラーメッセージを準備する。
                なお、この$errors はViewErrorBag型という特殊なデータ型のため
                以下のように記述することで配列のように扱うことが可能。--}}

            @foreach($errors->all() as $error)
                <p class="error text-danger">{{ $error }}</p>
            @endforeach
            <div class="row justify-content-center mt-4">
                <div class="col-12 text-center">
                    @if ($post->image !== '')
                        <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                    @else
                        <img class="img-fluid" src="{{ asset('images/no_image.png') }}" alt="no_image">
                    @endif        
                    <form class="mt-2 text-right" method="POST" action="{{ route('posts.edit_image', $post) }}">
                        <input type="submit" class="btn btn-light btn-outline-secondary" value="画像を変更する"> 
                    </form>
                </div>
            </div>
            <form class="mt-3" method="POST" action="{{ route('posts.update', $post) }}">
                @csrf
                @method('patch')
                <div class="form-group form-row">
                    <label for="title" class="col-md-2 col-form-label">タイトル</label>
                    <div class="col-md-10">
                        <input class="form-control count_title" id="title" type="text" name="title" placeholder="画像のタイトルを入力してください" value="{{ $post->title }}">
                        <div>
                            <span class="now_count_title">0</span> / 20 文字
                        </div>
                        <span class="over_count_title"></span>
                    </div>
                </div>
            
                <div class="form-group form-row">
                    <label for="comment" class="col-md-2 col-form-label">コメント</label>
                    {{-- 改行を有効にしつつ、エスケープする --}}
                    <div class="col-md-10">
                        <textarea class="form-control count_comment" id="comment" name="comment" placeholder="画像についてコメントを入力してください" rows="10">{{ $post->comment }}</textarea>
                        <div>
                            <span class="now_count_comment">0</span> / 150 文字
                        </div>
                        <span class="over_count_comment"></span>
                    </div>
                </div>
                
                <div class="form-group form-row">
                    <label for="category" class="col-md-2 col-form-label">カテゴリー</label>
                    <select id="category" class="col-md-6" name="category_id">
                        @forelse ($categories as $category)
                            @if ($category->id === $post->category_id)
                                <option value="{{ $category->id }}" selected>
                                    {{ $category->name }}
                                </option>
                            @else
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endif
                        @empty
                            カテゴリーは未設定です
                        @endforelse
                    </select>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 text-right">
                        <input class="submit btn btn-light btn-outline-secondary" type="submit" value="更新する">
                    </div>
                </div>
            </form>  
        </div>
    </div>
</div>
<script>
    // 選択した画像のプレビュー表示
    $('input[type=file]').on('change', function(e){
        // 画像ファイルの読み込みクラス
        let reader = new FileReader();
        reader.onload = function(e){
            // src属性に選択した画像ファイルの情報を設定
            $('.preview').attr('src', e.target.result);
        }
        // 読み込んだ画像ファイルをURLに変換
        reader.readAsDataURL(e.target.files[0]);
    });

    $('.count_title').on('input', function(){
        // 文字数を取得
        let count = $(this).val().length;
        // 現在の文字数を表示
        $('.now_count_title').text(count);
        if (count > 20) {
            // 既定の文字数を超えたときはメッセージを表示
            $('.now_count_title').addClass('text-danger');
            $('.over_count_title').text('タイトルの入力は20文字以下にしてください').addClass('text-danger');
            // 送信ボタンを無効化
            $('.submit').prop('disabled', true);
        } else {
            // 既定の文字数以内のときはメッセージを表示しない
            $('.now_count_title').removeClass('text-danger');
            $('.over_count_title').empty();
            // 送信ボタンを有効化
            $('.submit').prop('disabled', false);
        }
    });

    $('.count_comment').on('input', function(){
        // textarea の改行はLF:1文字、PHP側バリデーションは改行CRLF:2文字のため、バリデーションに合うよう改行コードを二文字に置き換え
        let count = $(this).val().replace(/\n/g, "\r\n").length;
        $('.now_count_comment').text(count);
        if (count > 150) {
            $('.now_count_comment').addClass('text-danger');
            $('.over_count_comment').text('コメントの入力は150文字以下にしてください').addClass('text-danger');
            $('.submit').prop('disabled', true);
        } else {
            $('.now_count_comment').removeClass('text-danger');
            $('.over_count_comment').empty();
            $('.submit').prop('disabled', false);
        }
    });

    // リロード時に初期文字列が入っていた時の処理
    $('.count_title').trigger('input');
    $('.count_comment').trigger('input');

</script>

@endsection