@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>{{ $user->name }} さん のプロフィール画像</h2>

            @foreach($errors->all() as $error)
            <p class="error text-danger">{{ $error }}</p>
            @endforeach
            
            {{-- 画像データ送信のため enctype を設定 --}}
            <form
            class="mt-3"
            method="POST"
            action="{{ route('users.update_image') }}"
            enctype="multipart/form-data"
            >
                @csrf
                @method('patch')
                <div class="form-group form-row justify-content-center">
                    {{-- 選択した画像のプレビュー表示 --}}
                    @if ($user->image !== '')
                        <img class="preview img-fluid col-9 col-md-7" src="{{ \Storage::url($user->image) }}">
                    @else
                        <img class="preview img-fluid col-9 col-md-7" src="{{ asset('images/profile_icon.png') }}">
                    @endif
                    <span class="pl-1 m-4">
                        <input type="file" name="image" class="form-control-file" value="{{ old('image') }}">
                    </span>
                </div>
                <div class="text-right mt-4">
                    <input type="submit" class="btn btn-light btn-outline-secondary" value="プロフィール画像を更新">                
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

</script>

@endsection