@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>当サイトについて</h2>
            <p class="mt-3">
                当サイトにアクセスしてくださり、ありがとうございます。
            </p>
            <p>
                当サイトは、花の投稿に特化したSNSです。
            </p>
            <p>
                このサイトにアクセスしてくださった方々が、花の画像を見ることで癒されたり、幸せな気持ちになってくださったら良いな、という想いで作成しました。
            </p>
            <p>
                花は私たちの身近にたくさんあります。身近にある当たり前の存在だからこそ、意識しないと、花の存在や美しさ、花の魅力に気づかないこともあると思うのです。
            </p>
            <p>
                そこで、このサイトを通じて、全国（世界）各地の様々な花を、皆さんそれぞれの視点で撮影した画像をシェアしていただけないでしょうか。
                皆さんの投稿によって、花に癒されたり、花の魅力に気づいたり、花の魅力を再発見したり、そのような方が増えると思うのです。
            </p>
            <p>
                花の投稿には
                @guest
                    <a href="{{ route('register') }}">無料の会員登録</a>
                @else
                    無料の会員登録
                @endguest
                が必要です。登録後は投稿に対するお気に入り登録機能や、投稿者をフォローする機能なども利用可能になり、当サイトがより使いやすくなります。
                サイトの閲覧のみでももちろん大歓迎ですが、ぜひ会員登録のうえ、皆さんの周りにある花をたくさん投稿していただきたいです。
            </p>
            @guest
                <div class="col-12 text-center mb-3">
                    <a class="btn btn-outline-info " href="{{ route('register') }}">
                        会員登録はこちらから
                    </a>
                </div>
            @endguest
            <p>
                当サイトを、花の画像であふれる素敵な場所にするためのお力添えを、どうぞよろしくお願いします。
            </p>
            <p class="text-right">2022.03.04 Flowers管理者より</p>
            <div class="col-12 text-center mb-3">
                <a class="btn btn-outline-info " href="{{ route('contact.index') }}">
                    お問い合わせはこちらから
                </a>
            </div>

        </div>
    </div>
</div>

@endsection