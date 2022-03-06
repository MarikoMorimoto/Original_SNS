@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>投稿検索</h2>
            <div class="row text-center mt-2">
                <!-- 検索フォーム -->
                <section class="col-12">
                    {{-- GET送信で検索すると、URLにキーワードが残るため、URLを保存することで同じ検索結果が得られるメリットがある --}}
                    <form action="{{ route('posts.index') }}" class="form-inline my-3 justify-content-center">
                        <div class="row form-group w-100">
                            <label class="sr-only" for="keyword">検索キーワード</label>
                            <input type="search" name="keyword" value="{{ request('keyword') }}" class="form-control col-10" placeholder="地名・花の名前など">
                            <button type="submit" class="btn btn-light border col-2">検索</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection