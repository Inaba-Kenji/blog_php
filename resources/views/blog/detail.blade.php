@extends('layout')
@section('title','詳細')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h2>{{ $blog->title }}</h2>
      <span>作成日：{{ $blog->created_at }}</span>
      <span>更新日：{{ $blog->updated_at }}</span>
      <p>{{ $blog->content }}</p>
      <form method="POST" action="{{ route('commentStore') }}" onSubmit="return checkSubmit()">
        @csrf
        <input name="id" type="hidden" value="{{ $blog->id }}">
        <div class="form-group">
          <label for="subject">名前</label>
          <input id="name" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" type="text">
          @if ($errors->has('name'))
            <div class="invalid-feedback">
              {{ $errors->first('name') }}
            </div>
          @endif
        </div>
        <div class="form-group">
          <label for="body">
            本文
          </label>
            <textarea id="comment" name="comment" class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" rows="4">{{ old('comment') }}</textarea>
            @if ($errors->has('comment'))
              <div class="invalid-feedback">
                {{ $errors->first('comment') }}
              </div>
            @endif
        </div>
        <div class="form-group mt-4">
          <button type="submit" class="btn btn-primary">
            コメントする
          </button>
        </div>
      </form>
      @if (session('commentstatus'))
          <div class="alert alert-success mt-4 mb-4">
            {{ session('commentstatus') }}
          </div>
      @endif
      </form>
      <div>
        @foreach ($blog->comments as $comment)
          <h4>{{ $comment->name }}</h4>
          <span>作成日：{{ $comment->created_at }}</span>
          <span>更新日：{{ $comment->updated_at }}</span>
          <p>{{ $comment->comment }}</p>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
