<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm kadai_002-header-containers fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="{{asset('img/logo.jpg')}}" class="header-logo">
    </a>
<!--     <form class="row g-1">
      <div class="col-auto">
        <input class="form-control kadai_002-header-search-input">
      </div>
      <div class="col-auto">
        <button type="submit" class="btn kadai_002-header-search-button"><i class="fas fa-search kadai_002-header-search-icon"></i></button>
      </div>
    </form> -->
<!--     <form action="{{ route('search') }}" method="GET" class="row g-1">
      <div class="col-auto">
          <input type="text" name="query" class="form-control" placeholder="検索キーワードを入力" value="{{ request('query') }}">
      </div>
      <div class="col-auto">
          <button type="submit" class="btn btn-primary">
              <i class="fas fa-search"></i>
          </button>
      </div>
    </form> -->

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav ms-auto mr-5 mt-2">
        <!-- Authentication Links -->
        @guest
        <li class="nav-item mr-5">
          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
        <li class="nav-item mr-5">
          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        <hr>
        <li class="nav-item mr-5">
          <a class="nav-link" href="{{ route('login') }}"><i class="far fa-heart"></i></a>
        </li>
        @else
        <li class="nav-item mr-5">
          <a class="nav-link" href="{{ route('mypage') }}">
            <i class="fas fa-user mr-1"></i><label>マイページ</label>
          </a>
        </li>
        <li class="nav-item mr-5">
          <a class="nav-link" href="{{ route('mypage.favorite') }}">
            <i class="far fa-heart"></i>
          </a>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>