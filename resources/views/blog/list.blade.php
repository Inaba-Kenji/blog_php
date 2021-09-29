@extends('layout')
@section('title','ブログ一覧')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <h2>ブログ記事一覧</h2>
      @if (session('err_msg'))
        <p class="text-danger">
          {{ session('err_msg')}}
        </p>
      @endif
      <table class="table table-striped">
        <tr>
            <th>タイトル</th>
            <th>日付</th>
            <th></th>
            <th></th>
            <td></td>
            <td></td>
        </tr>
        @foreach($blogs as $blog)
            <tr>
                <td><a href="/blog/{{ $blog->id }}">{{ $blog->title  }}</a></td>
                <td><img src="{{ '/storage/' . $blog['image']}}" class='rounded-circle' width="100" height="100"/></td>
                <td>{{ $blog->updated_at  }}</td>
                <td><button type="button" class="btn btn-success" onclick="location.href='/blog/edit/{{ $blog->id }}'">編集</button></td>
                <form method="POST" action="{{ route('delete', $blog->id) }}" onSubmit="return checkDelete()">
                  @csrf
                  <td><button type="submit" class="btn btn-danger">削除</button></td>
                </form>
                <td>
                  <div class="form-group mt-4">
                    @if($like_model->like_exist(Auth::user()->id,$blog->id))
                      <p class="favorite-marke">
                        <a class="js-like-toggle loved" href="" data-blogid="{{ $blog->id }}"><i class="fas fa-heart"></i></a>
                        <span class="likesCount">{{$blog->likes_count}}</span>
                      </p>
                    @else
                      <p class="favorite-marke">
                        <a class="js-like-toggle" href="" data-blogid="{{ $blog->id }}"><i class="fas fa-heart"></i></a>
                        <span class="likesCount">{{$blog->likes_count}}</span>
                      </p>
                    @endif  ​
                  </div>
                </td>
            </tr>
            @endforeach
      </table>
    </div>
  </div>
</div>
<script>
  function checkDelete(){
      if(window.confirm('削除してよろしいですか？')){
          return true;
      } else {
          return false;
      }
  }
  </script>
@endsection
