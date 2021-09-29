<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    /**
     *
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //テーブル名
    protected $table = 'blogs';

    // 可変項目
    protected $fillable =
    [
        'title',
        'content',
        'user_id',
        'image',
    ];
}
