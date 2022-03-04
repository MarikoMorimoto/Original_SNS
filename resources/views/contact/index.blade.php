@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>お問い合わせ</h2>
            {{-- エラーメッセージを出力 --}}
            @foreach($errors->all() as $error)
                <p class="error text-danger">{{ $error }}</p>
            @endforeach

            <form class="mt-3" method="POST" action="{{ route('contact.confirm') }}">
                @csrf
                <div class="form-group form-row">
                    <label for="email" class="col-md-3 col-form-label">メールアドレス</label>
                    <div class="col-md-9">
                        <input class="form-control" id="email" type="email" name="email" placeholder="メールアドレスを入力してください" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="form-group form-row">
                    <label for="title" class="col-md-3 col-form-label">タイトル</label>
                    <div class="col-md-9">
                        <input class="form-control count_title" id="title" type="text" name="title" placeholder="タイトルを入力してください" value="{{ old('title') }}">
                        <div>
                            <span class="now_count_title">0</span> / 30 文字
                        </div>
                        <span class="over_count_title"></span>
                    </div>
                </div>
                
                <div class="form-group form-row">
                    <label for="contact" class="col-md-3 col-form-label">お問い合わせ内容</label>
                    <div class="col-md-9">
                        <textarea class="form-control count_comment" id="contact" name="contact" placeholder="お問い合わせ内容を入力してください" rows="10">{{ old('contact') }}</textarea>
                        <div>
                            <span class="now_count_comment">0</span> / 1000 文字
                        </div>
                        <span class="over_count_comment"></span>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12 text-right">
                        <input class="submit btn btn-light btn-outline-secondary" type="submit" value="入力内容確認">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    $('.count_title').on('input', function(){
        // 文字数を取得
        let count = $(this).val().length;
        // 現在の文字数を表示
        $('.now_count_title').text(count);
        if (count > 30) {
            // 既定の文字数を超えたときはメッセージを表示
            $('.now_count_title').addClass('text-danger');
            $('.over_count_title').text('タイトルの入力は30文字以下にしてください').addClass('text-danger');
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
        if (count > 1000) {
            $('.now_count_comment').addClass('text-danger');
            $('.over_count_comment').text('お問い合わせ内容は1000文字以下にしてください').addClass('text-danger');
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