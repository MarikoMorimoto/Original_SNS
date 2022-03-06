@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-8">
            <h2>お問い合わせ内容確認</h2>
            <form class="mt-3" method="POST" action="{{ route('contact.send') }}">
                @csrf
                <div class="form-group form-row">
                    <label class="col-md-3 col-form-label">メールアドレス</label>
                    <div class="col-md-9 form-control">
                        {{ $inputs['email'] }}
                        <input id="email" type="hidden" name="email" value="{{ $inputs['email'] }}">
                    </div>
                </div>
                <div class="form-group form-row">
                    <label class="col-md-3 col-form-label">タイトル</label>
                    <div class="col-md-9 form-control">
                        {{ $inputs['title'] }}
                        <input id="title" type="hidden" name="title" value="{{ $inputs['title'] }}">
                    </div>
                </div>
                
                <div class="row">
                    <label class="col-12">お問い合わせ内容</label>
                    <div class="col-12 mt-2">
                        <div class="border px-3 py-2">
                            {!! nl2br(e($inputs['contact'])) !!}
                        </div>
                        <input id="contact" type="hidden" name="contact" value="{{ $inputs['contact'] }}">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 text-right mt-4">
                        <button type="submit" name="action" class="btn btn-light btn-outline-secondary" value="back">
                            入力内容を修正                      
                        </button>
                    </div>
                    <div class="col-md-12 text-right mt-4">
                        <button type="submit" name="action" class="btn btn-outline-info" value="submit">
                            この内容で送信する
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection