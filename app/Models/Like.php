<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //いいねしているユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //いいねしている投稿
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    //いいねが既にされているかを確認
    public function like_exist($id, $blog_id)
    {
        // Likesテーブルのレコードにユーザーidと投稿idが一致するものを取得
        $exist = Like::where('user_id', '=', $id)->where('blog_id', '=', $blog_id)->get();

        // レコード（$exist）が存在するなら
        if (!$exist->isEmpty()) {
            return true;
        } else {
            // レコード（$exist）が存在しないなら
            return false;
        }
    }
}
