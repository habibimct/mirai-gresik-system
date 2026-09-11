<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            MIRAI GRESIK SYSTEM
        </a>

        <div class="ms-auto">

            <span class="text-white me-3">

                {{ Auth::user()->name }}

            </span>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">

                @csrf

                <button class="btn btn-sm btn-light">
                    Logout
                </button>

            </form>

        </div>

    </div>

</nav>