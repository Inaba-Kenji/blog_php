<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js"></script>
</head>
<body>
  <header class="d-flex justify-content-center py-3">
    @include('header')
  </header>
  <div class="container">
    @yield('content')
  </div>
  <footer class="footer bg-dark  fixed-bottom">
    @include('footer')
  </footer>
</body>
</html>
