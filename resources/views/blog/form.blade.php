@extends('layout')
@section('title', 'ブログ投稿')
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <h2>ブログ投稿フォーム</h2>
    <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data" onSubmit="return checkSubmit()">
      @csrf
      <div class="form-group">
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
      </div>
      <div class="form-group">
          <label for="title">
              タイトル
          </label>
          {{-- セッションにフラッシュデーターとして保存されている直前の入力値を取得 --}}
          <input id="title" name="title" class="form-control"value="{{ old('title') }}" type="text">
          {{-- 指定したフィールドのエラーメッセージが存在しているかを判定 --}}
          @if ($errors->has('title'))
              <div class="text-danger">
                {{-- 指定したフィールドの最初のエラーメッセージを取得 --}}
                  {{ $errors->first('title') }}
              </div>
          @endif
      </div>
      <div class="form-group">
          <label for="content">
              本文
          </label>
          <textarea id="content" name="content" class="form-control" rows="4">{{ old('content') }}</textarea>
          @if ($errors->has('content'))
              <div class="text-danger">
                  {{ $errors->first('content') }}
              </div>
          @endif
      </div>
      <div class="form-group">
        <input id="image" type="file" name="image">
      </div>
      <div class="mt-5">
        <a class="btn btn-danger" href="{{ route('blogs') }}">
            キャンセル
        </a>
        <button type="submit" class="btn btn-primary">
            投稿する
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function checkSubmit(){
    if(window.confirm('送信してよろしいですか？')){
        return true;
    } else {
        return false;
    }
  }
</script>

@endsection