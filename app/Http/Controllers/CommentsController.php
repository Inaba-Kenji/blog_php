<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    /**
     * バリデーション、登録データの整形など
     */
    public function commentStore(CommentRequest $request)
    {
        $savedata = [
            'blog_id' => $request->id,
            'name' => $request->name,
            'comment' => $request->comment,
        ];

        $comment = new Comment;
        $comment->fill($savedata)->save();

        \Session::flash('commentstatus', 'コメントを投稿しました');
        return redirect(route('show', ['id' => $savedata['blog_id']]));
    }
}
