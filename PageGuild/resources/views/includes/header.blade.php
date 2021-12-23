<nav class="navbar navbar-expand-md navbar-light primary-color navbar-laravel">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <!-- esquerda -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form class="d-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search my-auto" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
                        <input class="form-control me-2 border-0 bg-transparent" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </li>
            </ul>
            <!-- logo -->
            <a class="navbar-brand" href="{{ url('/index') }}">
                <img src="../../images/logo.png" alt="" height="60">
            </a>
            <!-- direita -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{url('/about')}}" class="nav-link"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg></a>
                </li>
                <li class="nav-item">
                <a href="{{url('/about')}}" class="nav-link"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16"><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/></svg></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
