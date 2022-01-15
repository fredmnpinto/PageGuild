<nav class="navbar navbar-expand-md navbar-light primary-color navbar-laravel">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <div>
                        <form action="/search/results" method="POST" class="d-inline-flex">
                        @csrf
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search my-auto" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                            <input class="form-control me-2 border-0 bg-transparent" name="search" type="text" placeholder="Search" aria-label="Search">
                        </form>
                    </div>
                </li>
            </ul>
            <!-- logo -->
            <a class="navbar-brand" href="{{ url('/home') }}">
                <img src="/images/logo.png" alt="" height="60">
            </a>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">
                 <!-- Authentication Links -->
                 @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Registar-se') }}</a>
                        </li>
                    @endif

                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    {{ Auth::user()->name }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16"><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/></svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(count(\App\Http\Controllers\OrderController::getShoppingCartItems()) > 0)
                                    @foreach(\App\Http\Controllers\OrderController::getShoppingCartItems() as $item)
                                        <a class="dropdown-item" href="{{ route('showDetails', $item->id) }}">
                                        {{ $item->qty }}x <strong>{{ $item->name }}</strong> ({{ $item->total }}€)
                                        </a>
                                    @endforeach

                                    <a class="dropdown-item" style="font-weight: bold;" href="{{ route('order.checkout') }}">{{ __("Checkout") }}</a>
                                @else
                                    <span class="dropdown-item-text" disabled="disabled">{{ __("Empty...") }}</span>
                                @endif
                            </div>
                        </li>
                    @endguest
            </ul>
        </div>
    </div>
</nav>
