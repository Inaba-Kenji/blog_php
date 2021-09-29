
  <ul class="nav nav-pills">
    <li class="nav-item"><a href="{{ route('blogs') }}" class="nav-link" aria-current="page">ブログ一覧</a></li>
    <li class="nav-item"><a href="{{ route('create') }}" class="nav-link">ブログ投稿</a></li>
    <li class="nav-item"><a href="#" class="nav-link">FAQs</a></li>
    <li class="nav-item"><a href="#" class="nav-link">About</a></li>
    <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link"
      onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
    </li>
  </ul>