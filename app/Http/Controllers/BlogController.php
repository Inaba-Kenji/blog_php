<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Like;
use App\Http\Controllers\Auth;
use App\Http\Requests\BlogRequest;
use PhpParser\Node\Stmt\TryCatch;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ブログ一覧を表示する
     * @return view
     */
    public function showList()
    {
        $data = [];
        // ユーザの投稿の一覧を作成日時の降順で取得
        //withCount('テーブル名')とすることで、リレーションの数も取得できます。
        $blogs = Blog::withCount('likes')->orderBy('created_at', 'desc')->paginate(10);
        $like_model = new Like;

        $data = [
            'blogs' => $blogs,
            'like_model' => $like_model,
        ];

        return view('blog.list', $data);
    }
    /**
     * ブログ詳細を表示する
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }

        return view('blog.detail', ['blog' => $blog]);
    }

    /**
     * ブログ登録フォームを表示する
     * @return view
     */
    public function showCreate()
    {
        return view('blog.form');
    }


    /**
     * ブログを登録する
     * @return view
     */
    public function exeStore(BlogRequest $request)
    {
        // ブログのデータを受け取る
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store("images", "public");
            $inputs['image'] = $path;
        } else {
            $inputs['image'] = null;
        }

        \DB::beginTransaction();
        try {
            Blog::create($inputs);
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg', 'ブログを登録しました。');
        return redirect(route('blogs'));
    }

    /**
     * ブログ編集フォームを表示する
     * @parm int $id
     * @return view
     */
    public function showEdit($id)
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }

        return view('blog.edit', ['blog' => $blog]);
    }

    /**
     * ブログを更新する
     * @return view
     */
    public function exeUpdate(BlogRequest $request)
    {
        // ブログのデータを受け取る
        $inputs = $request->all();
        \DB::beginTransaction();
        try {
            // ブログを更新
            $blog = Blog::find($inputs['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content'],
            ]);
            $blog->save();
            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        \Session::flash('err_msg', 'ブログを更新しました。');
        return redirect(route('blogs'));
    }

    /**
     * ブログ削除する
     * @parm int $id
     * @return view
     */
    public function exeDelete($id)
    {

        if (empty($id)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }

        try {
            // ブログを削除
            Blog::destroy($id);
        } catch (\Throwable $e) {
            abort(500);
        }

        \Session::flash('err_msg', '削除しました。');
        return redirect(route('blogs'));
    }


    public function ajaxlike(Request $request)
    {
        $id = Auth::user()->id;
        $blog_id = $request->blog_id;
        $like = new Like;
        $blog = Blog::findOrFail($blog_id);

        // 空でない（既にいいねしている）なら
        if ($like->like_exist($id, $blog_id)) {
            //likesテーブルのレコードを削除
            $like = Like::where('blog_id', $blog_id)->where('user_id', $id)->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new Like;
            $like->blog_id = $request->blog_id;
            $like->user_id = Auth::user()->id;
            $like->save();
        }

        //loadCountとすればリレーションの数を○○_countという形で取得できる（今回の場合はいいねの総数）
        $blogLikesCount = $blog->loadCount('likes')->likes_count;

        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。笑
        $json = [
            'blogLikesCount' => $blogLikesCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    }
}
