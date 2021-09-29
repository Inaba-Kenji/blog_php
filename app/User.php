<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // 複数代入したいモデルの属性を指定
    protected $fillable = [
        'name', 'email', 'password', 'locked_flg', 'error_count',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    // モデルから変換する配列やJSONに、パスワードのような属性を含めたくない場合があります。それにはモデルの$hiddenプロパティに定義を追加してください。
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    // モデルの$castsプロパティは属性を一般的なデータタイプへキャストする便利な手法を提供します。
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    //User.phpに下記を追記
    // ユーザーの投稿
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    // ユーザーがいいねしている投稿
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
