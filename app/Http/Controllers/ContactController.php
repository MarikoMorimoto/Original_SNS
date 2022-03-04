<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ConfirmRequest;
use App\Http\Requests\SendRequest;
use App\Mail\ContactSendmail;

class ContactController extends Controller
{
    public function index(){
        return view('contact.index');
    }

    public function confirm(ConfirmRequest $request){
        // フォームから受け取ったすべての値を取得
        $inputs = $request->all();
        // 入力内容確認ページのviewに変数を渡して表示
        return view('contact.confirm', [
            'inputs' => $inputs,
        ]);
    }

    public function send(SendRequest $request){
        // フォームから受け取ったactionの値を取得
        $action = $request->input('action');
        // フォームから受け取ったaction の値を除いたinput の値を取得
        $inputs = $request->except('action');

        // actionの値で分岐
        if ($action !== 'submit'){
            return redirect()
                ->route('contact.index')
                ->withInput($inputs);
        } else  {
            // 入力されたメールアドレスにメールを送信
            \Mail::to($inputs['email'])->send(new ContactSendmail($inputs));

            // 再送信を防ぐためにトークンを再発行
            $request->session()->regenerateToken();

            // 送信完了ページのviewを表示
            return view('contact.thanks');
        }
    }
}
