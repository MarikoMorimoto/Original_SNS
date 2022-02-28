<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;
use App\Http\Requests\AjaxFollowRequest;

class FollowController extends Controller
{
    public function ajaxFollows(AjaxFollowRequest $request){
        $user = \Auth::user();
        $follow_user = User::find($request->follow_id);
        // ログインユーザーがすでに投稿者をフォローしている場合はフォローの取り消し
        if ($user->isFollowing($follow_user)) {
            $user->follows->where('follow_id', $follow_user->id)->first()->delete();
        } else {
            // まだフォローしていない場合はフォローテーブルにレコードを追加
            Follow::create([
                'user_id' => $user->id,
                'follow_id'=> $follow_user->id,
            ]);
        };
    }
}
