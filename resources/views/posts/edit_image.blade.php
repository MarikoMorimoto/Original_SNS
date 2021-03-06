@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>{{ $post->title }} の 画像変更</h2>

            @foreach($errors->all() as $error)
                <p class="error text-danger">{{ $error }}</p>
            @endforeach
            
            {{-- 画像データ送信のため enctype を設定 --}}
            <form
            class="mt-3"
            method="POST"
            action="{{ route('posts.update_image', $post) }}"
            enctype="multipart/form-data"
            >
                @csrf
                @method('patch')
                <div class="form-group form-row justify-content-center">
                    {{-- 選択した画像のプレビュー表示 --}}
                    @if ($post->image !== '')
                        <img class="preview img-fluid image-preview-max-height" src="{{ asset('storage/' . $post->image) }}" alt="previw">
                    @else
                        <img class="preview img-fluid image-preview-max-height" src="{{ asset('images/no_image.png') }}" alt="preview">
                    @endif                            
                    <span class="pl-1 mt-2">
                        <input type="file" name="image" class="form-control-file">
                    </span>
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
</script>

@endsection