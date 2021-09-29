<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * 
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    //テーブル名
    protected $table = 'comments';

    // 可変項目
    protected $fillable =
    [
        'blog_id',
        'name',
        'comment',
    ];
}
