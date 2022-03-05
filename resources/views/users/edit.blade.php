@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>{{ $user->name }} さん のプロフィール</h2>

            <form method="POST" class="mt-3" action="{{ route('users.update') }}">
                @csrf
                @method('patch')
                <div class="form-group form-row">
                    <label for="user_name" class="col-md-2 col-form-label">お名前</label>
                    <div class="col-md-10">
                        <input class="form-control count_name @error('name') is-invalid @enderror" id="user_name" type="text" name="name" placeholder="お名前を入力してください" value="{{ $user->name }}">
                        <div>
                            <span class="now_count_name">0</span> / 20 文字
                        </div>
                        <span class="over_count_name"></span>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>
                
                <div class="form-group form-row">
                    <label for="profile" class="col-md-2 col-form-profile">プロフィール</label>
                    {{-- 改行を有効にしつつ、エスケープする --}}
                    <div class="col-md-10">
                        <textarea class="form-control count_profile @error('profile') is-invalid @enderror" id="profile" name="profile" placeholder="自己紹介文などをご自由に入力してください" rows="10">{{ $user->profile }}</textarea>
                        <div>
                            <span class="now_count_profile">0</span> / 200 文字
                        </div>
                        <span class="over_count_profile"></span>
                        @error('profile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-right">
                        <input class="submit btn btn-light btn-outline-secondary" type="submit" value="プロフィールを更新する">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    $('.count_name').on('input', function(){
        // 文字数を取得
        let count = $(this).val().length;
        // 現在の文字数を表示
        $('.now_count_name').text(count);
        if (count > 20) {
            // 既定の文字数を超えたときはメッセージを表示
            $('.now_count_name').addClass('text-danger');
            $('.over_count_name').text('お名前の入力は20文字以下にしてください').addClass('text-danger');
            // 送信ボタンを無効化
            $('.submit').prop('disabled', true);
        } else {
            // 既定の文字数以内のときはメッセージを表示しない
            $('.now_count_name').removeClass('text-danger');
            $('.over_count_name').empty();
            // 送信ボタンを有効化
            $('.submit').prop('disabled', false);
        }
    });

    $('.count_profile').on('input', function(){
        // textarea の改行はLF:1文字、PHP側バリデーションは改行CRLF:2文字のため、バリデーションに合うよう改行コードを二文字に置き換え
        let count = $(this).val().replace(/\n/g, "\r\n").length;
        $('.now_count_profile').text(count);
        if (count > 200) {
            $('.now_count_profile').addClass('text-danger');
            $('.over_count_profile').text('自由記入欄は200文字以下にしてください').addClass('text-danger');
            $('.submit').prop('disabled', true);
        } else {
            $('.now_count_profile').removeClass('text-danger');
            $('.over_count_profile').empty();
            $('.submit').prop('disabled', false);
        }
    });

    // リロード時に初期文字列が入っていた時の処理
    $('.count_name').trigger('input');
    $('.count_profile').trigger('input');

</script>

@endsection